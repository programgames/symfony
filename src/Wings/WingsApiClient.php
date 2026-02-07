<?php

namespace App\Wings;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WingsApiClient
{
    private HttpClientInterface $client;
    private string $applicationApiUrl;

    public function __construct(HttpClientInterface $client,string $applicationApiUrl)
    {
        $this->client = $client;
        $this->applicationApiUrl = rtrim($applicationApiUrl, '/');
    }

    public function wingsRequest(string $daemonToken, string $endpoint): array
    {
        $response = $this->client->request('GET', $this->applicationApiUrl . $endpoint, [
            'headers' => [
                'Authorization' => "Bearer {$daemonToken}",
                'Accept' => 'Application/vnd.pterodactyl.v1+json'
            ],
        ]);

        return $response->toArray();
    }
}
