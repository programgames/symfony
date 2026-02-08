<?php

namespace App\Pokemon;

/**
 * Pokemon data organized by generation
 * Names and types are loaded from JSON files for all generations
 */
final class PokemonData
{
    public const GENERATIONS = [
        1 => ['name' => 'Generation I', 'range' => [1, 151]],
        2 => ['name' => 'Generation II', 'range' => [152, 251]],
        3 => ['name' => 'Generation III', 'range' => [252, 386]],
        4 => ['name' => 'Generation IV', 'range' => [387, 493]],
        5 => ['name' => 'Generation V', 'range' => [494, 649]],
        6 => ['name' => 'Generation VI', 'range' => [650, 721]],
        7 => ['name' => 'Generation VII', 'range' => [722, 809]],
        8 => ['name' => 'Generation VIII', 'range' => [810, 905]],
        9 => ['name' => 'Generation IX', 'range' => [906, 1025]],
    ];

    /**
     * Pokemon types by language
     * Key: type code, Value: array of translations
     */
    private const TYPE_NAMES = [
        'normal' => ['fr' => 'Normal', 'en' => 'Normal'],
        'fire' => ['fr' => 'Feu', 'en' => 'Fire'],
        'water' => ['fr' => 'Eau', 'en' => 'Water'],
        'electric' => ['fr' => 'Electrik', 'en' => 'Electric'],
        'grass' => ['fr' => 'Plante', 'en' => 'Grass'],
        'ice' => ['fr' => 'Glace', 'en' => 'Ice'],
        'fighting' => ['fr' => 'Combat', 'en' => 'Fighting'],
        'poison' => ['fr' => 'Poison', 'en' => 'Poison'],
        'ground' => ['fr' => 'Sol', 'en' => 'Ground'],
        'flying' => ['fr' => 'Vol', 'en' => 'Flying'],
        'psychic' => ['fr' => 'Psy', 'en' => 'Psychic'],
        'bug' => ['fr' => 'Insecte', 'en' => 'Bug'],
        'rock' => ['fr' => 'Roche', 'en' => 'Rock'],
        'ghost' => ['fr' => 'Spectre', 'en' => 'Ghost'],
        'dragon' => ['fr' => 'Dragon', 'en' => 'Dragon'],
        'dark' => ['fr' => 'Ténèbres', 'en' => 'Dark'],
        'steel' => ['fr' => 'Acier', 'en' => 'Steel'],
        'fairy' => ['fr' => 'Fée', 'en' => 'Fairy'],
    ];

    private static ?array $loadedData = null;

    /**
     * Load Pokemon data from JSON file
     */
    private static function loadData(): array
    {
        if (self::$loadedData !== null) {
            return self::$loadedData;
        }

        $dataPath = dirname(__DIR__, 2) . '/data/pokemon_data.json';

        if (file_exists($dataPath)) {
            $json = file_get_contents($dataPath);
            self::$loadedData = json_decode($json, true) ?? [];
        } else {
            self::$loadedData = [];
        }

        return self::$loadedData;
    }

    /**
     * Get available generations
     * @return array<int, array{name: string, range: array{0: int, 1: int}, available: bool}>
     */
    public static function getGenerations(): array
    {
        $data = self::loadData();
        $generations = [];

        foreach (self::GENERATIONS as $gen => $genData) {
            [$start, $end] = $genData['range'];

            // Check if we have data for this generation
            $hasData = false;
            for ($id = $start; $id <= $end; $id++) {
                if (isset($data[$id])) {
                    $hasData = true;
                    break;
                }
            }

            $generations[$gen] = [
                ...$genData,
                'available' => $hasData,
            ];
        }

        return $generations;
    }

    /**
     * Get Pokemon IDs for a specific generation
     * @return int[]
     */
    public static function getPokemonIdsForGeneration(int $generation): array
    {
        if (!isset(self::GENERATIONS[$generation])) {
            throw new \InvalidArgumentException("Generation $generation does not exist");
        }

        [$start, $end] = self::GENERATIONS[$generation]['range'];
        return range($start, $end);
    }

    /**
     * Get Pokemon name by ID and language
     */
    public static function getPokemonName(int $id, string $language = 'fr'): ?string
    {
        $data = self::loadData();

        if (!isset($data[$id])) {
            return null;
        }

        $names = $data[$id]['names'] ?? [];
        return $names[$language] ?? $names['en'] ?? null;
    }

    /**
     * Get all Pokemon for a generation with their names
     * @return array<int, array{id: int, name: string}>
     */
    public static function getPokemonForGeneration(int $generation, string $language = 'fr'): array
    {
        $ids = self::getPokemonIdsForGeneration($generation);
        $pokemon = [];

        foreach ($ids as $id) {
            $name = self::getPokemonName($id, $language);
            if ($name !== null) {
                $pokemon[$id] = [
                    'id' => $id,
                    'name' => $name,
                ];
            }
        }

        return $pokemon;
    }

    /**
     * Get the count of Pokemon in a generation
     */
    public static function getGenerationCount(int $generation): int
    {
        if (!isset(self::GENERATIONS[$generation])) {
            return 0;
        }

        [$start, $end] = self::GENERATIONS[$generation]['range'];
        return $end - $start + 1;
    }

    /**
     * Normalize a string for comparison (remove accents, spaces, special chars)
     */
    public static function normalizeForComparison(string $input): string
    {
        // Convert to lowercase
        $normalized = mb_strtolower($input, 'UTF-8');

        // Remove accents
        $normalized = self::removeAccents($normalized);

        // Remove spaces, hyphens, dots, and special characters
        $normalized = preg_replace('/[\s\-\.\'\"\:\!]/', '', $normalized);

        // Handle Nidoran special case - remove gender symbols
        $normalized = str_replace(['♀', '♂', 'f', 'm'], '', $normalized);

        // Remove "mr" or "m" prefix for Mr. Mime style names
        if (str_starts_with($normalized, 'mrmime') || str_starts_with($normalized, 'mmime')) {
            $normalized = 'mrmime';
        }

        return $normalized;
    }

    /**
     * Remove accents from a string
     */
    private static function removeAccents(string $string): string
    {
        $accents = [
            'à' => 'a', 'â' => 'a', 'ä' => 'a', 'á' => 'a', 'ã' => 'a',
            'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'é' => 'e',
            'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'í' => 'i',
            'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'ó' => 'o', 'õ' => 'o',
            'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ú' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ];

        return strtr($string, $accents);
    }

    /**
     * Check if user input matches a Pokemon name
     */
    public static function checkAnswer(string $input, int $pokemonId, string $language = 'fr'): bool
    {
        $pokemonName = self::getPokemonName($pokemonId, $language);
        if ($pokemonName === null) {
            return false;
        }

        $normalizedInput = self::normalizeForComparison($input);
        $normalizedName = self::normalizeForComparison($pokemonName);

        // Special handling for Nidoran - accept "nidoran" for both
        if ($pokemonId === 29 || $pokemonId === 32) {
            if (str_starts_with($normalizedInput, 'nidoran')) {
                return true;
            }
        }

        return $normalizedInput === $normalizedName;
    }

    /**
     * Get the local audio path for a Pokemon cry
     * @param string $version 'latest' or 'legacy'
     */
    public static function getLocalCryPath(int $pokemonId, string $version = 'latest'): string
    {
        return "/audio/pokemon/{$version}/{$pokemonId}.ogg";
    }

    /**
     * Get the remote audio URL for a Pokemon cry (fallback)
     * @param string $version 'latest' or 'legacy'
     */
    public static function getCryUrl(int $pokemonId, string $version = 'latest'): string
    {
        return "https://raw.githubusercontent.com/PokeAPI/cries/main/cries/pokemon/{$version}/{$pokemonId}.ogg";
    }

    /**
     * Get Pokemon types by ID
     * @return string[] Array of type codes
     */
    public static function getPokemonTypes(int $id): array
    {
        $data = self::loadData();
        return $data[$id]['types'] ?? [];
    }

    /**
     * Get Pokemon types translated
     * @return string[] Array of translated type names
     */
    public static function getPokemonTypesTranslated(int $id, string $language = 'fr'): array
    {
        $types = self::getPokemonTypes($id);
        $translated = [];

        foreach ($types as $type) {
            $translated[] = self::TYPE_NAMES[$type][$language] ?? self::TYPE_NAMES[$type]['en'] ?? ucfirst($type);
        }

        return $translated;
    }

    /**
     * Clear loaded data cache (useful for testing)
     */
    public static function clearCache(): void
    {
        self::$loadedData = null;
    }
}
