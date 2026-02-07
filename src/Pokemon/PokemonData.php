<?php

namespace App\Pokemon;

/**
 * Pokemon data organized by generation
 * Names are stored by language code for future i18n support
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
     * Pokemon names by language
     * Key: Pokemon ID, Value: array of names by language code
     */
    private const NAMES = [
        // Generation 1 (1-151)
        1 => ['fr' => 'Bulbizarre', 'en' => 'Bulbasaur'],
        2 => ['fr' => 'Herbizarre', 'en' => 'Ivysaur'],
        3 => ['fr' => 'Florizarre', 'en' => 'Venusaur'],
        4 => ['fr' => 'Salamèche', 'en' => 'Charmander'],
        5 => ['fr' => 'Reptincel', 'en' => 'Charmeleon'],
        6 => ['fr' => 'Dracaufeu', 'en' => 'Charizard'],
        7 => ['fr' => 'Carapuce', 'en' => 'Squirtle'],
        8 => ['fr' => 'Carabaffe', 'en' => 'Wartortle'],
        9 => ['fr' => 'Tortank', 'en' => 'Blastoise'],
        10 => ['fr' => 'Chenipan', 'en' => 'Caterpie'],
        11 => ['fr' => 'Chrysacier', 'en' => 'Metapod'],
        12 => ['fr' => 'Papilusion', 'en' => 'Butterfree'],
        13 => ['fr' => 'Aspicot', 'en' => 'Weedle'],
        14 => ['fr' => 'Coconfort', 'en' => 'Kakuna'],
        15 => ['fr' => 'Dardargnan', 'en' => 'Beedrill'],
        16 => ['fr' => 'Roucool', 'en' => 'Pidgey'],
        17 => ['fr' => 'Roucoups', 'en' => 'Pidgeotto'],
        18 => ['fr' => 'Roucarnage', 'en' => 'Pidgeot'],
        19 => ['fr' => 'Rattata', 'en' => 'Rattata'],
        20 => ['fr' => 'Rattatac', 'en' => 'Raticate'],
        21 => ['fr' => 'Piafabec', 'en' => 'Spearow'],
        22 => ['fr' => 'Rapasdepic', 'en' => 'Fearow'],
        23 => ['fr' => 'Abo', 'en' => 'Ekans'],
        24 => ['fr' => 'Arbok', 'en' => 'Arbok'],
        25 => ['fr' => 'Pikachu', 'en' => 'Pikachu'],
        26 => ['fr' => 'Raichu', 'en' => 'Raichu'],
        27 => ['fr' => 'Sabelette', 'en' => 'Sandshrew'],
        28 => ['fr' => 'Sablaireau', 'en' => 'Sandslash'],
        29 => ['fr' => 'Nidoran♀', 'en' => 'Nidoran♀'],
        30 => ['fr' => 'Nidorina', 'en' => 'Nidorina'],
        31 => ['fr' => 'Nidoqueen', 'en' => 'Nidoqueen'],
        32 => ['fr' => 'Nidoran♂', 'en' => 'Nidoran♂'],
        33 => ['fr' => 'Nidorino', 'en' => 'Nidorino'],
        34 => ['fr' => 'Nidoking', 'en' => 'Nidoking'],
        35 => ['fr' => 'Mélofée', 'en' => 'Clefairy'],
        36 => ['fr' => 'Mélodelfe', 'en' => 'Clefable'],
        37 => ['fr' => 'Goupix', 'en' => 'Vulpix'],
        38 => ['fr' => 'Feunard', 'en' => 'Ninetales'],
        39 => ['fr' => 'Rondoudou', 'en' => 'Jigglypuff'],
        40 => ['fr' => 'Grodoudou', 'en' => 'Wigglytuff'],
        41 => ['fr' => 'Nosferapti', 'en' => 'Zubat'],
        42 => ['fr' => 'Nosferalto', 'en' => 'Golbat'],
        43 => ['fr' => 'Mystherbe', 'en' => 'Oddish'],
        44 => ['fr' => 'Ortide', 'en' => 'Gloom'],
        45 => ['fr' => 'Rafflesia', 'en' => 'Vileplume'],
        46 => ['fr' => 'Paras', 'en' => 'Paras'],
        47 => ['fr' => 'Parasect', 'en' => 'Parasect'],
        48 => ['fr' => 'Mimitoss', 'en' => 'Venonat'],
        49 => ['fr' => 'Aéromite', 'en' => 'Venomoth'],
        50 => ['fr' => 'Taupiqueur', 'en' => 'Diglett'],
        51 => ['fr' => 'Triopikeur', 'en' => 'Dugtrio'],
        52 => ['fr' => 'Miaouss', 'en' => 'Meowth'],
        53 => ['fr' => 'Persian', 'en' => 'Persian'],
        54 => ['fr' => 'Psykokwak', 'en' => 'Psyduck'],
        55 => ['fr' => 'Akwakwak', 'en' => 'Golduck'],
        56 => ['fr' => 'Férosinge', 'en' => 'Mankey'],
        57 => ['fr' => 'Colossinge', 'en' => 'Primeape'],
        58 => ['fr' => 'Caninos', 'en' => 'Growlithe'],
        59 => ['fr' => 'Arcanin', 'en' => 'Arcanine'],
        60 => ['fr' => 'Ptitard', 'en' => 'Poliwag'],
        61 => ['fr' => 'Têtarte', 'en' => 'Poliwhirl'],
        62 => ['fr' => 'Tartard', 'en' => 'Poliwrath'],
        63 => ['fr' => 'Abra', 'en' => 'Abra'],
        64 => ['fr' => 'Kadabra', 'en' => 'Kadabra'],
        65 => ['fr' => 'Alakazam', 'en' => 'Alakazam'],
        66 => ['fr' => 'Machoc', 'en' => 'Machop'],
        67 => ['fr' => 'Machopeur', 'en' => 'Machoke'],
        68 => ['fr' => 'Mackogneur', 'en' => 'Machamp'],
        69 => ['fr' => 'Chétiflor', 'en' => 'Bellsprout'],
        70 => ['fr' => 'Boustiflor', 'en' => 'Weepinbell'],
        71 => ['fr' => 'Empiflor', 'en' => 'Victreebel'],
        72 => ['fr' => 'Tentacool', 'en' => 'Tentacool'],
        73 => ['fr' => 'Tentacruel', 'en' => 'Tentacruel'],
        74 => ['fr' => 'Racaillou', 'en' => 'Geodude'],
        75 => ['fr' => 'Gravalanch', 'en' => 'Graveler'],
        76 => ['fr' => 'Grolem', 'en' => 'Golem'],
        77 => ['fr' => 'Ponyta', 'en' => 'Ponyta'],
        78 => ['fr' => 'Galopa', 'en' => 'Rapidash'],
        79 => ['fr' => 'Ramoloss', 'en' => 'Slowpoke'],
        80 => ['fr' => 'Flagadoss', 'en' => 'Slowbro'],
        81 => ['fr' => 'Magnéti', 'en' => 'Magnemite'],
        82 => ['fr' => 'Magnéton', 'en' => 'Magneton'],
        83 => ['fr' => 'Canarticho', 'en' => 'Farfetch\'d'],
        84 => ['fr' => 'Doduo', 'en' => 'Doduo'],
        85 => ['fr' => 'Dodrio', 'en' => 'Dodrio'],
        86 => ['fr' => 'Otaria', 'en' => 'Seel'],
        87 => ['fr' => 'Lamantine', 'en' => 'Dewgong'],
        88 => ['fr' => 'Tadmorv', 'en' => 'Grimer'],
        89 => ['fr' => 'Grotadmorv', 'en' => 'Muk'],
        90 => ['fr' => 'Kokiyas', 'en' => 'Shellder'],
        91 => ['fr' => 'Crustabri', 'en' => 'Cloyster'],
        92 => ['fr' => 'Fantominus', 'en' => 'Gastly'],
        93 => ['fr' => 'Spectrum', 'en' => 'Haunter'],
        94 => ['fr' => 'Ectoplasma', 'en' => 'Gengar'],
        95 => ['fr' => 'Onix', 'en' => 'Onix'],
        96 => ['fr' => 'Soporifik', 'en' => 'Drowzee'],
        97 => ['fr' => 'Hypnomade', 'en' => 'Hypno'],
        98 => ['fr' => 'Krabby', 'en' => 'Krabby'],
        99 => ['fr' => 'Krabboss', 'en' => 'Kingler'],
        100 => ['fr' => 'Voltorbe', 'en' => 'Voltorb'],
        101 => ['fr' => 'Électrode', 'en' => 'Electrode'],
        102 => ['fr' => 'Noeunoeuf', 'en' => 'Exeggcute'],
        103 => ['fr' => 'Noadkoko', 'en' => 'Exeggutor'],
        104 => ['fr' => 'Osselait', 'en' => 'Cubone'],
        105 => ['fr' => 'Ossatueur', 'en' => 'Marowak'],
        106 => ['fr' => 'Kicklee', 'en' => 'Hitmonlee'],
        107 => ['fr' => 'Tygnon', 'en' => 'Hitmonchan'],
        108 => ['fr' => 'Excelangue', 'en' => 'Lickitung'],
        109 => ['fr' => 'Smogo', 'en' => 'Koffing'],
        110 => ['fr' => 'Smogogo', 'en' => 'Weezing'],
        111 => ['fr' => 'Rhinocorne', 'en' => 'Rhyhorn'],
        112 => ['fr' => 'Rhinoféros', 'en' => 'Rhydon'],
        113 => ['fr' => 'Leveinard', 'en' => 'Chansey'],
        114 => ['fr' => 'Saquedeneu', 'en' => 'Tangela'],
        115 => ['fr' => 'Kangourex', 'en' => 'Kangaskhan'],
        116 => ['fr' => 'Hypotrempe', 'en' => 'Horsea'],
        117 => ['fr' => 'Hypocéan', 'en' => 'Seadra'],
        118 => ['fr' => 'Poissirène', 'en' => 'Goldeen'],
        119 => ['fr' => 'Poissoroy', 'en' => 'Seaking'],
        120 => ['fr' => 'Stari', 'en' => 'Staryu'],
        121 => ['fr' => 'Staross', 'en' => 'Starmie'],
        122 => ['fr' => 'M. Mime', 'en' => 'Mr. Mime'],
        123 => ['fr' => 'Insécateur', 'en' => 'Scyther'],
        124 => ['fr' => 'Lippoutou', 'en' => 'Jynx'],
        125 => ['fr' => 'Élektek', 'en' => 'Electabuzz'],
        126 => ['fr' => 'Magmar', 'en' => 'Magmar'],
        127 => ['fr' => 'Scarabrute', 'en' => 'Pinsir'],
        128 => ['fr' => 'Tauros', 'en' => 'Tauros'],
        129 => ['fr' => 'Magicarpe', 'en' => 'Magikarp'],
        130 => ['fr' => 'Léviator', 'en' => 'Gyarados'],
        131 => ['fr' => 'Lokhlass', 'en' => 'Lapras'],
        132 => ['fr' => 'Métamorph', 'en' => 'Ditto'],
        133 => ['fr' => 'Évoli', 'en' => 'Eevee'],
        134 => ['fr' => 'Aquali', 'en' => 'Vaporeon'],
        135 => ['fr' => 'Voltali', 'en' => 'Jolteon'],
        136 => ['fr' => 'Pyroli', 'en' => 'Flareon'],
        137 => ['fr' => 'Porygon', 'en' => 'Porygon'],
        138 => ['fr' => 'Amonita', 'en' => 'Omanyte'],
        139 => ['fr' => 'Amonistar', 'en' => 'Omastar'],
        140 => ['fr' => 'Kabuto', 'en' => 'Kabuto'],
        141 => ['fr' => 'Kabutops', 'en' => 'Kabutops'],
        142 => ['fr' => 'Ptéra', 'en' => 'Aerodactyl'],
        143 => ['fr' => 'Ronflex', 'en' => 'Snorlax'],
        144 => ['fr' => 'Artikodin', 'en' => 'Articuno'],
        145 => ['fr' => 'Électhor', 'en' => 'Zapdos'],
        146 => ['fr' => 'Sulfura', 'en' => 'Moltres'],
        147 => ['fr' => 'Minidraco', 'en' => 'Dratini'],
        148 => ['fr' => 'Draco', 'en' => 'Dragonair'],
        149 => ['fr' => 'Dracolosse', 'en' => 'Dragonite'],
        150 => ['fr' => 'Mewtwo', 'en' => 'Mewtwo'],
        151 => ['fr' => 'Mew', 'en' => 'Mew'],
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
        'fairy' => ['fr' => 'Fee', 'en' => 'Fairy'],
    ];

    /**
     * Pokemon types (Generation 1)
     * Key: Pokemon ID, Value: array of type codes
     */
    private const TYPES = [
        1 => ['grass', 'poison'],
        2 => ['grass', 'poison'],
        3 => ['grass', 'poison'],
        4 => ['fire'],
        5 => ['fire'],
        6 => ['fire', 'flying'],
        7 => ['water'],
        8 => ['water'],
        9 => ['water'],
        10 => ['bug'],
        11 => ['bug'],
        12 => ['bug', 'flying'],
        13 => ['bug', 'poison'],
        14 => ['bug', 'poison'],
        15 => ['bug', 'poison'],
        16 => ['normal', 'flying'],
        17 => ['normal', 'flying'],
        18 => ['normal', 'flying'],
        19 => ['normal'],
        20 => ['normal'],
        21 => ['normal', 'flying'],
        22 => ['normal', 'flying'],
        23 => ['poison'],
        24 => ['poison'],
        25 => ['electric'],
        26 => ['electric'],
        27 => ['ground'],
        28 => ['ground'],
        29 => ['poison'],
        30 => ['poison'],
        31 => ['poison', 'ground'],
        32 => ['poison'],
        33 => ['poison'],
        34 => ['poison', 'ground'],
        35 => ['fairy'],
        36 => ['fairy'],
        37 => ['fire'],
        38 => ['fire'],
        39 => ['normal', 'fairy'],
        40 => ['normal', 'fairy'],
        41 => ['poison', 'flying'],
        42 => ['poison', 'flying'],
        43 => ['grass', 'poison'],
        44 => ['grass', 'poison'],
        45 => ['grass', 'poison'],
        46 => ['bug', 'grass'],
        47 => ['bug', 'grass'],
        48 => ['bug', 'poison'],
        49 => ['bug', 'poison'],
        50 => ['ground'],
        51 => ['ground'],
        52 => ['normal'],
        53 => ['normal'],
        54 => ['water'],
        55 => ['water'],
        56 => ['fighting'],
        57 => ['fighting'],
        58 => ['fire'],
        59 => ['fire'],
        60 => ['water'],
        61 => ['water'],
        62 => ['water', 'fighting'],
        63 => ['psychic'],
        64 => ['psychic'],
        65 => ['psychic'],
        66 => ['fighting'],
        67 => ['fighting'],
        68 => ['fighting'],
        69 => ['grass', 'poison'],
        70 => ['grass', 'poison'],
        71 => ['grass', 'poison'],
        72 => ['water', 'poison'],
        73 => ['water', 'poison'],
        74 => ['rock', 'ground'],
        75 => ['rock', 'ground'],
        76 => ['rock', 'ground'],
        77 => ['fire'],
        78 => ['fire'],
        79 => ['water', 'psychic'],
        80 => ['water', 'psychic'],
        81 => ['electric'],
        82 => ['electric'],
        83 => ['normal', 'flying'],
        84 => ['normal', 'flying'],
        85 => ['normal', 'flying'],
        86 => ['water'],
        87 => ['water', 'ice'],
        88 => ['poison'],
        89 => ['poison'],
        90 => ['water'],
        91 => ['water', 'ice'],
        92 => ['ghost', 'poison'],
        93 => ['ghost', 'poison'],
        94 => ['ghost', 'poison'],
        95 => ['rock', 'ground'],
        96 => ['psychic'],
        97 => ['psychic'],
        98 => ['water'],
        99 => ['water'],
        100 => ['electric'],
        101 => ['electric'],
        102 => ['grass', 'psychic'],
        103 => ['grass', 'psychic'],
        104 => ['ground'],
        105 => ['ground'],
        106 => ['fighting'],
        107 => ['fighting'],
        108 => ['normal'],
        109 => ['poison'],
        110 => ['poison'],
        111 => ['ground', 'rock'],
        112 => ['ground', 'rock'],
        113 => ['normal'],
        114 => ['grass'],
        115 => ['normal'],
        116 => ['water'],
        117 => ['water'],
        118 => ['water'],
        119 => ['water'],
        120 => ['water'],
        121 => ['water', 'psychic'],
        122 => ['psychic', 'fairy'],
        123 => ['bug', 'flying'],
        124 => ['ice', 'psychic'],
        125 => ['electric'],
        126 => ['fire'],
        127 => ['bug'],
        128 => ['normal'],
        129 => ['water'],
        130 => ['water', 'flying'],
        131 => ['water', 'ice'],
        132 => ['normal'],
        133 => ['normal'],
        134 => ['water'],
        135 => ['electric'],
        136 => ['fire'],
        137 => ['normal'],
        138 => ['rock', 'water'],
        139 => ['rock', 'water'],
        140 => ['rock', 'water'],
        141 => ['rock', 'water'],
        142 => ['rock', 'flying'],
        143 => ['normal'],
        144 => ['ice', 'flying'],
        145 => ['electric', 'flying'],
        146 => ['fire', 'flying'],
        147 => ['dragon'],
        148 => ['dragon'],
        149 => ['dragon', 'flying'],
        150 => ['psychic'],
        151 => ['psychic'],
    ];

    /**
     * Get available generations (currently only gen 1 is supported)
     * @return array<int, array{name: string, range: array{0: int, 1: int}, available: bool}>
     */
    public static function getGenerations(): array
    {
        $generations = [];
        foreach (self::GENERATIONS as $gen => $data) {
            $generations[$gen] = [
                ...$data,
                'available' => $gen === 1, // Only gen 1 is available for now
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
        return self::NAMES[$id][$language] ?? self::NAMES[$id]['en'] ?? null;
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
        $normalized = preg_replace('/[\s\-\.\'\"]/', '', $normalized);

        // Handle Nidoran special case - remove gender symbols
        $normalized = str_replace(['♀', '♂', 'f', 'm'], '', $normalized);

        // Remove "mr" or "m" prefix for Mr. Mime
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
            // For Nidoran♀ (29) and Nidoran♂ (32), also accept just "nidoran"
            // but we need to be careful - the quiz should differentiate them
            // For simplicity, accept "nidoran" + any suffix or just the base
            if (str_starts_with($normalizedInput, 'nidoran')) {
                return true;
            }
        }

        return $normalizedInput === $normalizedName;
    }

    /**
     * Get the audio URL for a Pokemon cry
     */
    public static function getCryUrl(int $pokemonId): string
    {
        return "https://raw.githubusercontent.com/PokeAPI/cries/main/cries/pokemon/latest/{$pokemonId}.ogg";
    }

    /**
     * Get Pokemon types by ID
     * @return string[] Array of type codes
     */
    public static function getPokemonTypes(int $id): array
    {
        return self::TYPES[$id] ?? [];
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
            $translated[] = self::TYPE_NAMES[$type][$language] ?? self::TYPE_NAMES[$type]['en'] ?? $type;
        }

        return $translated;
    }
}
