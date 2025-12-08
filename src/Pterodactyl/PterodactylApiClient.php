<?php

namespace App\Pterodactyl;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PterodactylApiClient
{
    private HttpClientInterface $client;
    private string $adminApiKey;

    private string $clientApiKey;
    private string $clientApiUrl;

    private string $applicationApiUrl;

    public function __construct(HttpClientInterface $client, string $adminApiKey,string $clientApiKey, string $clientApiUrl, string $applicationApiUrl)
    {
        $this->client = $client;
        $this->adminApiKey = $adminApiKey;
        $this->clientApiKey = $clientApiKey;
        $this->clientApiUrl = rtrim($clientApiUrl, '/');
        $this->applicationApiUrl = rtrim($applicationApiUrl, '/');
    }

    public function adminRequest(string $endpoint): array
    {
        $response = $this->client->request('GET', $this->applicationApiUrl . $endpoint, [
            'headers' => [
                'Authorization' => "Bearer {$this->adminApiKey}",
                'Accept' => 'Application/vnd.pterodactyl.v1+json'
            ],
        ]);

        return $response->toArray();
    }

    public function clientRequest(string $endpoint): array
    {
        $response = $this->client->request('GET', $this->clientApiUrl . $endpoint, [
            'headers' => [
                'Authorization' => "Bearer {$this->clientApiKey}",
                'Accept' => 'Application/vnd.pterodactyl.v1+json'
            ],
        ]);

        return $response->toArray();
    }
}
