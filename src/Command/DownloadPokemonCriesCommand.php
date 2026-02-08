<?php

namespace App\Command;

use App\Pokemon\PokemonData;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'pokemon:download-cries',
    description: 'Download all Pokemon cries (gen 1-9) for offline use'
)]
class DownloadPokemonCriesCommand extends Command
{
    private const CRY_URL = 'https://raw.githubusercontent.com/PokeAPI/cries/main/cries/pokemon/%s/%d.ogg';
    private const VERSIONS = ['latest', 'legacy'];
    private const PARALLEL_DOWNLOADS = 5;
    private const FAILED_CACHE_FILE = 'pokemon_cries_not_found.json';

    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force re-download of all cries (including previously failed)')
            ->addOption('cry-version', null, InputOption::VALUE_OPTIONAL, 'Download only specific version (latest/legacy)', null)
            ->addOption('generation', 'g', InputOption::VALUE_OPTIONAL, 'Download only specific generation (1-9)', null)
            ->addOption('parallel', 'p', InputOption::VALUE_OPTIONAL, 'Number of parallel downloads', self::PARALLEL_DOWNLOADS)
            ->addOption('retry-failed', null, InputOption::VALUE_NONE, 'Retry previously failed downloads');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $forceDownload = $input->getOption('force');
        $specificVersion = $input->getOption('cry-version');
        $specificGeneration = $input->getOption('generation');
        $parallelDownloads = (int) $input->getOption('parallel');
        $retryFailed = $input->getOption('retry-failed');

        if ($parallelDownloads < 1 || $parallelDownloads > 20) {
            $parallelDownloads = self::PARALLEL_DOWNLOADS;
        }

        // Validate options
        if ($specificVersion !== null && !in_array($specificVersion, self::VERSIONS, true)) {
            $io->error('Invalid version. Use "latest" or "legacy".');
            return Command::FAILURE;
        }

        if ($specificGeneration !== null) {
            $specificGeneration = (int) $specificGeneration;
            if ($specificGeneration < 1 || $specificGeneration > 9) {
                $io->error('Invalid generation. Use 1-9.');
                return Command::FAILURE;
            }
        }

        $versions = $specificVersion ? [$specificVersion] : self::VERSIONS;
        $audioDir = $this->projectDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'audio' . DIRECTORY_SEPARATOR . 'pokemon';
        $cacheFile = $this->projectDir . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . self::FAILED_CACHE_FILE;

        // Load failed downloads cache
        $failedCache = [];
        if (file_exists($cacheFile) && !$forceDownload && !$retryFailed) {
            $failedCache = json_decode(file_get_contents($cacheFile), true) ?? [];
        }

        // Create directories
        foreach ($versions as $version) {
            $versionDir = $audioDir . DIRECTORY_SEPARATOR . $version;
            if (!is_dir($versionDir)) {
                mkdir($versionDir, 0777, true);
                $io->info("Created directory: $versionDir");
            }
        }

        // Determine which Pokemon to download
        $generations = PokemonData::GENERATIONS;
        if ($specificGeneration !== null) {
            $generations = [$specificGeneration => $generations[$specificGeneration]];
        }

        // Build download queue
        $queue = [];
        $skippedNotFound = 0;
        foreach ($versions as $version) {
            foreach ($generations as $genData) {
                [$start, $end] = $genData['range'];
                for ($id = $start; $id <= $end; $id++) {
                    $path = $audioDir . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . "{$id}.ogg";
                    $cacheKey = "{$version}/{$id}";

                    // Skip if file exists
                    if (file_exists($path) && !$forceDownload) {
                        continue;
                    }

                    // Skip if previously failed (404)
                    if (isset($failedCache[$cacheKey]) && !$forceDownload && !$retryFailed) {
                        $skippedNotFound++;
                        continue;
                    }

                    $queue[] = [
                        'id' => $id,
                        'version' => $version,
                        'url' => sprintf(self::CRY_URL, $version, $id),
                        'path' => $path,
                        'cacheKey' => $cacheKey,
                    ];
                }
            }
        }

        $totalToDownload = count($queue);
        $totalPossible = 0;
        foreach ($generations as $genData) {
            $totalPossible += $genData['range'][1] - $genData['range'][0] + 1;
        }
        $totalPossible *= count($versions);
        $skippedExists = $totalPossible - $totalToDownload - $skippedNotFound;

        $io->title('Pokemon Cry Downloader');
        $io->info([
            sprintf('Generations: %s', $specificGeneration ?? '1-9'),
            sprintf('Versions: %s', implode(', ', $versions)),
            sprintf('Files to download: %d', $totalToDownload),
            sprintf('Already exists (skipped): %d', $skippedExists),
            sprintf('Not available (skipped): %d', $skippedNotFound),
            sprintf('Parallel downloads: %d', $parallelDownloads),
            sprintf('Destination: %s', $audioDir),
        ]);

        if ($totalToDownload === 0) {
            $io->success('All files already downloaded! Use --force or --retry-failed to re-download.');
            return Command::SUCCESS;
        }

        $downloaded = 0;
        $failed = 0;
        $newFailed = [];

        $progressBar = $io->createProgressBar($totalToDownload);
        $progressBar->start();

        // Process queue in batches using curl_multi
        $batches = array_chunk($queue, $parallelDownloads);

        foreach ($batches as $batch) {
            $results = $this->downloadBatch($batch);

            foreach ($results as $result) {
                if ($result['success']) {
                    $downloaded++;
                    // Remove from failed cache if it was there
                    unset($failedCache[$result['item']['cacheKey']]);
                } else {
                    $failed++;
                    // Add to failed cache
                    $newFailed[$result['item']['cacheKey']] = [
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
        $dataDir = dirname($cacheFile);
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }
        file_put_contents($cacheFile, json_encode($failedCache, JSON_PRETTY_PRINT));

        if ($failed > 0) {
            $io->warning(sprintf('%d files not available (cached to avoid retrying)', $failed));
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
     * Download a batch of files in parallel using curl_multi
     * @return array<array{item: array, success: bool, http_code: int}>
     */
    private function downloadBatch(array $batch): array
    {
        $multiHandle = curl_multi_init();
        $handles = [];

        // Initialize curl handles
        foreach ($batch as $index => $item) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $item['url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_USERAGENT => 'Pokemon Quiz App/1.0',
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
