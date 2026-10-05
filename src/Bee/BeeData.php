<?php

namespace App\Bee;

/**
 * Données de croisement d'abeilles (Forestry, ExtraBees, MagicBees, CareerBees,
 * Gendustry, MeatballCraft), snapshot figé issu de https://at-l4s.github.io/BeeBreeding/
 */
final class BeeData
{
    private const DATA_FILE = '/data/bee_breeding.json';

    private static ?array $loadedData = null;

    /**
     * @return array{bees: array<string, array{n: string, m: string, b: string, c: string, p: list<string>}>, mutations: list<array{a: string, b: string, c: string, ch: float|null, r: list<array{k: string, v: list<mixed>}>}>}
     */
    public static function all(): array
    {
        if (self::$loadedData !== null) {
            return self::$loadedData;
        }

        $path = dirname(__DIR__, 2).self::DATA_FILE;

        if (!is_file($path)) {
            throw new \RuntimeException(sprintf('Fichier de données abeilles introuvable : %s', $path));
        }

        $data = json_decode((string) file_get_contents($path), true, 512, \JSON_THROW_ON_ERROR);

        return self::$loadedData = $data;
    }

    /**
     * Liste des mods présents dans les données, triés par nombre d'abeilles décroissant.
     *
     * @return list<array{id: string, count: int}>
     */
    public static function mods(): array
    {
        $counts = [];

        foreach (self::all()['bees'] as $bee) {
            $counts[$bee['m']] = ($counts[$bee['m']] ?? 0) + 1;
        }

        arsort($counts);

        return array_map(
            static fn (string $id, int $count): array => ['id' => $id, 'count' => $count],
            array_keys($counts),
            $counts,
        );
    }
}
