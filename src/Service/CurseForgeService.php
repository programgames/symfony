<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurseForgeService
{
    private const CURSEFORGE_SEARCH_URL = 'https://www.curseforge.com/minecraft/modpacks/search?search=';
    private const CURSEFORGE_API_URL = 'https://api.curseforge.com/v1';
    private const MINECRAFT_GAME_ID = 432;
    private const MODPACKS_CLASS_ID = 4471;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ?string $curseForgeApiKey = null,
    ) {
    }

    /**
     * Search for a modpack on CurseForge by name
     * Returns the best matching modpack URL or a search URL as fallback
     */
    public function findModpackUrl(string $serverName): ?array
    {
        $searchTerms = $this->extractSearchTerms($serverName);

        if (empty($searchTerms)) {
            return null;
        }

        // Try API search if we have an API key
        if ($this->curseForgeApiKey) {
            $result = $this->searchViaApi($searchTerms);
            if ($result) {
                return $result;
            }
        }

        // Fallback to search URL
        return [
            'url' => self::CURSEFORGE_SEARCH_URL . urlencode($searchTerms),
            'name' => null,
            'isDirectLink' => false,
        ];
    }

    /**
     * Extract meaningful search terms from server name
     */
    private function extractSearchTerms(string $serverName): string
    {
        // Common patterns to remove
        $patternsToRemove = [
            '/\s*-?\s*server\s*/i',
            '/\s*-?\s*serveur\s*/i',
            '/\s*\d+\.\d+(\.\d+)?\s*/', // Version numbers like 1.20.1
            '/\s*-\s*$/',
            '/^\s*-\s*/',
            '/\s+/',
        ];

        $cleaned = $serverName;
        foreach ($patternsToRemove as $pattern) {
            $cleaned = preg_replace($pattern, ' ', $cleaned);
        }

        return trim($cleaned);
    }

    /**
     * Search via CurseForge API
     */
    private function searchViaApi(string $searchTerms): ?array
    {
        try {
            $response = $this->httpClient->request('GET', self::CURSEFORGE_API_URL . '/mods/search', [
                'headers' => [
                    'x-api-key' => $this->curseForgeApiKey,
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'gameId' => self::MINECRAFT_GAME_ID,
                    'classId' => self::MODPACKS_CLASS_ID,
                    'searchFilter' => $searchTerms,
                    'sortField' => 2, // Popularity
                    'sortOrder' => 'desc',
                    'pageSize' => 1,
                ],
            ]);

            $data = $response->toArray();

            if (!empty($data['data'][0])) {
                $modpack = $data['data'][0];
                return [
                    'url' => $modpack['links']['websiteUrl'] ?? null,
                    'name' => $modpack['name'] ?? null,
                    'logo' => $modpack['logo']['thumbnailUrl'] ?? null,
                    'isDirectLink' => true,
                ];
            }
        } catch (\Exception $e) {
            // Silently fail and use fallback
        }

        return null;
    }
}
