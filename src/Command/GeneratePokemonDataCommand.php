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
    name: 'pokemon:generate-data',
    description: 'Generate Pokemon names and types data from PokeAPI for all generations'
)]
class GeneratePokemonDataCommand extends Command
{
    private const POKEAPI_POKEMON_URL = 'https://pokeapi.co/api/v2/pokemon-species/%d';
    private const POKEAPI_POKEMON_TYPES_URL = 'https://pokeapi.co/api/v2/pokemon/%d';
    private const PARALLEL_REQUESTS = 5;

    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('start', null, InputOption::VALUE_OPTIONAL, 'Start Pokemon ID', 1)
            ->addOption('end', null, InputOption::VALUE_OPTIONAL, 'End Pokemon ID', 1025)
            ->addOption('output', 'o', InputOption::VALUE_OPTIONAL, 'Output file path', null)
            ->addOption('parallel', 'p', InputOption::VALUE_OPTIONAL, 'Number of parallel requests', self::PARALLEL_REQUESTS)
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force re-fetch all Pokemon data');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $startId = (int) $input->getOption('start');
        $endId = (int) $input->getOption('end');
        $outputPath = $input->getOption('output') ?? $this->projectDir . '/data/pokemon_data.json';
        $parallelRequests = (int) $input->getOption('parallel');
        $force = $input->getOption('force');

        if ($parallelRequests < 1 || $parallelRequests > 10) {
            $parallelRequests = self::PARALLEL_REQUESTS;
        }

        $io->title('Pokemon Data Generator');

        // Load existing data if any
        $existingData = [];
        if (file_exists($outputPath) && !$force) {
            $existingJson = file_get_contents($outputPath);
            $existingData = json_decode($existingJson, true) ?? [];
            $io->info(sprintf('Loaded %d existing Pokemon from file', count($existingData)));
        }

        // Build queue of Pokemon to fetch
        $queue = [];
        for ($id = $startId; $id <= $endId; $id++) {
            if (!isset($existingData[$id]) || $force) {
                $queue[] = $id;
            }
        }

        $totalToFetch = count($queue);
        $skipped = ($endId - $startId + 1) - $totalToFetch;

        $io->info([
            sprintf('Pokemon range: %d to %d', $startId, $endId),
            sprintf('To fetch: %d', $totalToFetch),
            sprintf('Already exists (skipped): %d', $skipped),
            sprintf('Parallel requests: %d', $parallelRequests),
            sprintf('Output: %s', $outputPath),
        ]);

        if ($totalToFetch === 0) {
            $io->success('All Pokemon data already exists! Use --force to re-fetch.');
            return Command::SUCCESS;
        }

        $pokemonData = $existingData;
        $fetched = 0;
        $failed = [];

        $progressBar = $io->createProgressBar($totalToFetch);
        $progressBar->start();

        // Process in batches
        $batches = array_chunk($queue, $parallelRequests);

        foreach ($batches as $batch) {
            $results = $this->fetchBatch($batch);

            foreach ($results as $id => $data) {
                if ($data !== null) {
                    $pokemonData[$id] = $data;
                    $fetched++;
                } else {
                    $failed[] = $id;
                }
                $progressBar->advance();
            }

            // Small delay between batches to respect rate limits
            usleep(100000); // 100ms
        }

        $progressBar->finish();
        $io->newLine(2);

        // Sort by ID
        ksort($pokemonData);

        // Save to JSON file
        $dataDir = dirname($outputPath);
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        file_put_contents($outputPath, json_encode($pokemonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        if (count($failed) > 0) {
            $io->warning(sprintf('Failed to fetch %d Pokemon: %s', count($failed), implode(', ', array_slice($failed, 0, 20))));
        }

        $io->success([
            sprintf('Total Pokemon in file: %d', count($pokemonData)),
            sprintf('Fetched: %d', $fetched),
            sprintf('Skipped (already exists): %d', $skipped),
            sprintf('Failed: %d', count($failed)),
            sprintf('Saved to: %s', $outputPath),
        ]);

        return Command::SUCCESS;
    }

    /**
     * Fetch a batch of Pokemon data in parallel
     */
    private function fetchBatch(array $ids): array
    {
        // First, fetch all species data (for names)
        $speciesResults = $this->fetchUrls(
            array_map(fn($id) => ['id' => $id, 'url' => sprintf(self::POKEAPI_POKEMON_URL, $id)], $ids)
        );

        // Then fetch all pokemon data (for types)
        $pokemonResults = $this->fetchUrls(
            array_map(fn($id) => ['id' => $id, 'url' => sprintf(self::POKEAPI_POKEMON_TYPES_URL, $id)], $ids)
        );

        // Combine results
        $results = [];
        foreach ($ids as $id) {
            $speciesData = $speciesResults[$id] ?? null;
            $pokemonData = $pokemonResults[$id] ?? null;

            if ($speciesData === null) {
                $results[$id] = null;
                continue;
            }

            // Extract names
            $names = ['en' => '', 'fr' => ''];
            if (isset($speciesData['names'])) {
                foreach ($speciesData['names'] as $nameEntry) {
                    $lang = $nameEntry['language']['name'];
                    if ($lang === 'en') {
                        $names['en'] = $nameEntry['name'];
                    } elseif ($lang === 'fr') {
                        $names['fr'] = $nameEntry['name'];
                    }
                }
            }

            // Fallback: use English name for French if not available
            if (empty($names['fr'])) {
                $names['fr'] = $names['en'];
            }

            // Extract types
            $types = [];
            if ($pokemonData !== null && isset($pokemonData['types'])) {
                foreach ($pokemonData['types'] as $typeEntry) {
                    $types[] = $typeEntry['type']['name'];
                }
            }

            $results[$id] = [
                'names' => $names,
                'types' => $types,
            ];
        }

        return $results;
    }

    /**
     * Fetch multiple URLs in parallel using curl_multi
     */
    private function fetchUrls(array $items): array
    {
        $multiHandle = curl_multi_init();
        $handles = [];

        foreach ($items as $item) {
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
            $handles[$item['id']] = $ch;
        }

        // Execute all requests
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
            curl_multi_select($multiHandle);
        } while ($running > 0);

        // Collect results
        $results = [];
        foreach ($handles as $id => $ch) {
            $content = curl_multi_getcontent($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200 && $content !== false) {
                $results[$id] = json_decode($content, true);
            } else {
                $results[$id] = null;
            }

            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        curl_multi_close($multiHandle);

        return $results;
    }
}
