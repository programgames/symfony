<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'pokemon:download-sprites',
    description: 'Download all Pokemon sprites from PokemonDB for offline use'
)]
class DownloadPokemonSpritesCommand extends Command
{
    // PNG sprites with transparent background from PokeAPI
    private const SPRITE_URL = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/%d.png';
    private const PARALLEL_DOWNLOADS = 5;
    private const FAILED_CACHE_FILE = 'pokemon_sprites_not_found.json';

    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force re-download of all sprites')
            ->addOption('parallel', 'p', InputOption::VALUE_OPTIONAL, 'Number of parallel downloads', self::PARALLEL_DOWNLOADS)
            ->addOption('retry-failed', null, InputOption::VALUE_NONE, 'Retry previously failed downloads');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $forceDownload = $input->getOption('force');
        $parallelDownloads = (int) $input->getOption('parallel');
        $retryFailed = $input->getOption('retry-failed');

        if ($parallelDownloads < 1 || $parallelDownloads > 20) {
            $parallelDownloads = self::PARALLEL_DOWNLOADS;
        }

        $spritesDir = $this->projectDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'pokemon';
        $dataFile = $this->projectDir . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'pokemon_data.json';
        $cacheFile = $this->projectDir . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . self::FAILED_CACHE_FILE;

        // Check if pokemon data exists
        if (!file_exists($dataFile)) {
            $io->error('Pokemon data file not found. Run pokemon:generate-data first.');
            return Command::FAILURE;
        }

        // Load pokemon data
        $pokemonData = json_decode(file_get_contents($dataFile), true);
        if (empty($pokemonData)) {
            $io->error('Pokemon data file is empty.');
            return Command::FAILURE;
        }

        // Create directory
        if (!is_dir($spritesDir)) {
            mkdir($spritesDir, 0777, true);
            $io->info("Created directory: $spritesDir");
        }

        // Load failed downloads cache
        $failedCache = [];
        if (file_exists($cacheFile) && !$forceDownload && !$retryFailed) {
            $failedCache = json_decode(file_get_contents($cacheFile), true) ?? [];
        }

        // Build download queue
        $queue = [];
        $skippedExists = 0;
        $skippedNotFound = 0;

        foreach ($pokemonData as $id => $data) {
            $englishName = $data['names']['en'] ?? null;
            if (!$englishName) {
                continue;
            }

            $path = $spritesDir . DIRECTORY_SEPARATOR . "{$id}.png";

            // Skip if file exists
            if (file_exists($path) && !$forceDownload) {
                $skippedExists++;
                continue;
            }

            // Skip if previously failed
            if (isset($failedCache[$id]) && !$forceDownload && !$retryFailed) {
                $skippedNotFound++;
                continue;
            }

            $queue[] = [
                'id' => $id,
                'name' => $englishName,
                'url' => sprintf(self::SPRITE_URL, (int)$id),
                'path' => $path,
            ];
        }

        $totalToDownload = count($queue);

        $io->title('Pokemon Sprite Downloader');
        $io->info([
            sprintf('Total Pokemon: %d', count($pokemonData)),
            sprintf('Files to download: %d', $totalToDownload),
            sprintf('Already exists (skipped): %d', $skippedExists),
            sprintf('Not available (skipped): %d', $skippedNotFound),
            sprintf('Parallel downloads: %d', $parallelDownloads),
            sprintf('Destination: %s', $spritesDir),
        ]);

        if ($totalToDownload === 0) {
            $io->success('All sprites already downloaded! Use --force or --retry-failed to re-download.');
            return Command::SUCCESS;
        }

        $downloaded = 0;
        $failed = 0;
        $newFailed = [];

        $progressBar = $io->createProgressBar($totalToDownload);
        $progressBar->start();

        // Process queue in batches
        $batches = array_chunk($queue, $parallelDownloads);

        foreach ($batches as $batch) {
            $results = $this->downloadBatch($batch);

            foreach ($results as $result) {
                if ($result['success']) {
                    $downloaded++;
                    unset($failedCache[$result['item']['id']]);
                } else {
                    $failed++;
                    $newFailed[$result['item']['id']] = [
                        'name' => $result['item']['name'],
                        'url' => $result['item']['url'],
                        'http_code' => $result['http_code'],
                        'date' => date('Y-m-d H:i:s'),
                    ];
                }
                $progressBar->advance();
            }
        }

        $progressBar->finish();
        $io->newLine(2);

        // Save failed cache
        $failedCache = array_merge($failedCache, $newFailed);
        file_put_contents($cacheFile, json_encode($failedCache, JSON_PRETTY_PRINT));

        if ($failed > 0) {
            $io->warning(sprintf('%d sprites failed to download', $failed));
        }

        $io->success([
            'Download complete!',
            sprintf('Downloaded: %d', $downloaded),
            sprintf('Skipped (already exists): %d', $skippedExists),
            sprintf('Not available: %d', $skippedNotFound + $failed),
        ]);

        return Command::SUCCESS;
    }

    /**
     * Format Pokemon name for URL
     */
    private function formatNameForUrl(string $name): string
    {
        // Convert to lowercase
        $urlName = strtolower($name);

        // Handle special characters and forms
        $replacements = [
            ' ' => '-',
            '.' => '',
            '\'' => '',
            "\u{2019}" => '',  // Right single quotation mark (curly quote)
            ':' => '',
            '♀' => '-f',
            '♂' => '-m',
            'é' => 'e',
            'É' => 'e',
        ];

        $urlName = strtr($urlName, $replacements);

        // Handle specific Pokemon name variations
        $specialCases = [
            'nidoran-f' => 'nidoran-f',
            'nidoran-m' => 'nidoran-m',
            'mr-mime' => 'mr-mime',
            'mime-jr' => 'mime-jr',
            'type-null' => 'type-null',
            'jangmo-o' => 'jangmo-o',
            'hakamo-o' => 'hakamo-o',
            'kommo-o' => 'kommo-o',
            'tapu-koko' => 'tapu-koko',
            'tapu-lele' => 'tapu-lele',
            'tapu-bulu' => 'tapu-bulu',
            'tapu-fini' => 'tapu-fini',
            'ho-oh' => 'ho-oh',
            'porygon-z' => 'porygon-z',
            'porygon2' => 'porygon2',
        ];

        return $specialCases[$urlName] ?? $urlName;
    }

    /**
     * Download a batch of files in parallel using curl_multi
     */
    private function downloadBatch(array $batch): array
    {
        $multiHandle = curl_multi_init();
        $handles = [];

        foreach ($batch as $index => $item) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $item['url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]);

            curl_multi_add_handle($multiHandle, $ch);
            $handles[$index] = [
                'handle' => $ch,
                'item' => $item,
            ];
        }

        // Execute all requests
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
            curl_multi_select($multiHandle);
        } while ($running > 0);

        // Collect results
        $results = [];
        foreach ($handles as $data) {
            $ch = $data['handle'];
            $item = $data['item'];

            $content = curl_multi_getcontent($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $success = false;
            if ($httpCode === 200 && $content !== false && strlen($content) > 0) {
                file_put_contents($item['path'], $content);
                $success = true;
            }

            $results[] = [
                'item' => $item,
                'success' => $success,
                'http_code' => $httpCode,
            ];

            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        curl_multi_close($multiHandle);

        return $results;
    }
}
