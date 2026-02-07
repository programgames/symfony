<?php

namespace App\Command;

use App\Pokemon\PokemonData;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'pokemon:analyze-cries',
    description: 'Analyze Pokemon cries to detect similar sounds using audio fingerprinting'
)]
class AnalyzePokemonCriesCommand extends Command
{
    private const CRY_URL = 'https://raw.githubusercontent.com/PokeAPI/cries/main/cries/pokemon/latest/%d.ogg';
    private const SIMILARITY_THRESHOLD = 0.70;

    protected function configure(): void
    {
        $this
            ->addOption('threshold', 't', InputOption::VALUE_OPTIONAL, 'Similarity threshold (0.0-1.0)', self::SIMILARITY_THRESHOLD)
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force re-download of all cries');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $threshold = (float) $input->getOption('threshold');
        $forceDownload = $input->getOption('force');

        // Check if fpcalc is available
        $fpcalcCheck = shell_exec('fpcalc -version 2>&1');
        if ($fpcalcCheck === null || !str_contains($fpcalcCheck, 'fpcalc')) {
            $io->error([
                'fpcalc (Chromaprint) is not installed or not in PATH.',
                'Install it:',
                '  - Windows: Download from https://acoustid.org/chromaprint',
                '  - Linux: apt install libchromaprint-tools',
                '  - macOS: brew install chromaprint',
            ]);
            return Command::FAILURE;
        }

        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'pokemon_cries';
        $dataDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'data';

        // Create directories
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        // Step 1: Download all cries (1-151)
        $io->section('Downloading Pokemon cries...');
        $progressBar = $io->createProgressBar(151);
        $progressBar->start();

        for ($id = 1; $id <= 151; $id++) {
            $url = sprintf(self::CRY_URL, $id);
            $path = $tempDir . DIRECTORY_SEPARATOR . "{$id}.ogg";

            if (!file_exists($path) || $forceDownload) {
                $content = @file_get_contents($url);
                if ($content !== false) {
                    file_put_contents($path, $content);
                } else {
                    $io->warning("Failed to download cry for Pokemon #$id");
                }
            }
            $progressBar->advance();
        }
        $progressBar->finish();
        $io->newLine(2);

        // Step 2: Generate fingerprints
        $io->section('Generating audio fingerprints...');
        $fingerprints = [];
        $progressBar = $io->createProgressBar(151);
        $progressBar->start();

        for ($id = 1; $id <= 151; $id++) {
            $path = $tempDir . DIRECTORY_SEPARATOR . "{$id}.ogg";
            if (!file_exists($path)) {
                $progressBar->advance();
                continue;
            }

            // Use fpcalc to generate raw fingerprint
            $escapedPath = escapeshellarg($path);
            $output = shell_exec("fpcalc -raw $escapedPath 2>&1");

            if ($output && preg_match('/FINGERPRINT=(.+)/', $output, $matches)) {
                $fingerprints[$id] = array_map('intval', explode(',', trim($matches[1])));
            }
            $progressBar->advance();
        }
        $progressBar->finish();
        $io->newLine(2);

        $io->info(sprintf('Generated %d fingerprints', count($fingerprints)));

        // Step 3: Compare all pairs
        $io->section('Comparing fingerprints...');
        $similarities = [];
        $totalComparisons = (151 * 150) / 2;
        $progressBar = $io->createProgressBar($totalComparisons);
        $progressBar->start();

        $ids = array_keys($fingerprints);
        for ($i = 0; $i < count($ids); $i++) {
            for ($j = $i + 1; $j < count($ids); $j++) {
                $id1 = $ids[$i];
                $id2 = $ids[$j];

                $similarity = $this->compareFingerprints($fingerprints[$id1], $fingerprints[$id2]);

                if ($similarity >= $threshold) {
                    if (!isset($similarities[$id1])) {
                        $similarities[$id1] = [];
                    }
                    if (!isset($similarities[$id2])) {
                        $similarities[$id2] = [];
                    }

                    $similarities[$id1][] = [
                        'id' => $id2,
                        'name' => PokemonData::getPokemonName($id2),
                        'similarity' => round($similarity, 2),
                    ];
                    $similarities[$id2][] = [
                        'id' => $id1,
                        'name' => PokemonData::getPokemonName($id1),
                        'similarity' => round($similarity, 2),
                    ];
                }
                $progressBar->advance();
            }
        }
        $progressBar->finish();
        $io->newLine(2);

        // Sort similarities by similarity score (descending)
        foreach ($similarities as &$similar) {
            usort($similar, fn($a, $b) => $b['similarity'] <=> $a['similarity']);
        }
        unset($similar);

        // Step 4: Save results
        $jsonPath = $dataDir . DIRECTORY_SEPARATOR . 'similar_cries.json';
        file_put_contents($jsonPath, json_encode($similarities, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $io->success([
            sprintf('Analysis complete! Found %d Pokemon with similar cries.', count($similarities)),
            sprintf('Results saved to: %s', $jsonPath),
        ]);

        // Show summary
        if (count($similarities) > 0) {
            $io->section('Pokemon with similar cries:');
            $rows = [];
            foreach ($similarities as $id => $similar) {
                $pokemonName = PokemonData::getPokemonName($id);
                $similarNames = array_map(fn($s) => sprintf('%s (%.0f%%)', $s['name'], $s['similarity'] * 100), $similar);
                $rows[] = [
                    "#$id $pokemonName",
                    implode(', ', $similarNames),
                ];
            }
            $io->table(['Pokemon', 'Similar to'], $rows);
        }

        return Command::SUCCESS;
    }

    /**
     * Compare two fingerprints using bit-level Hamming distance
     */
    private function compareFingerprints(array $fp1, array $fp2): float
    {
        $minLen = min(count($fp1), count($fp2));
        if ($minLen === 0) {
            return 0.0;
        }

        // Use a sliding window approach for better matching
        // since cries might have different lengths or offsets
        $maxSimilarity = 0.0;
        $maxOffset = min(20, $minLen / 4); // Allow some offset

        for ($offset = -$maxOffset; $offset <= $maxOffset; $offset++) {
            $matches = 0;
            $comparisons = 0;

            for ($i = 0; $i < $minLen; $i++) {
                $j = $i + $offset;
                if ($j < 0 || $j >= count($fp2)) {
                    continue;
                }
                if ($i >= count($fp1)) {
                    continue;
                }

                // Count matching bits using XOR and popcount
                $xor = $fp1[$i] ^ $fp2[$j];
                $matchingBits = 32 - $this->popcount($xor);
                $matches += $matchingBits;
                $comparisons += 32;
            }

            if ($comparisons > 0) {
                $similarity = $matches / $comparisons;
                $maxSimilarity = max($maxSimilarity, $similarity);
            }
        }

        return $maxSimilarity;
    }

    /**
     * Count the number of set bits (1s) in an integer
     */
    private function popcount(int $n): int
    {
        // Handle negative numbers (32-bit signed integers)
        if ($n < 0) {
            $n = $n & 0xFFFFFFFF;
        }

        $count = 0;
        while ($n) {
            $count += $n & 1;
            $n = ($n >> 1) & 0x7FFFFFFF;
        }
        return $count;
    }
}
