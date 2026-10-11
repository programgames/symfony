<?php

namespace App\Wings;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WingsApiClient
{
    private HttpClientInterface $client;
    private string $applicationApiUrl;
    private string $daemonToken;

    public function __construct(HttpClientInterface $client, string $applicationApiUrl, string $daemonToken)
    {
        $this->client = $client;
        $this->applicationApiUrl = rtrim($applicationApiUrl, '/');
        $this->daemonToken = $daemonToken;
    }

    public function wingsRequest(string $endpoint): array
    {
        $response = $this->client->request('GET', $this->applicationApiUrl . $endpoint, [
            'headers' => [
                'Authorization' => "Bearer {$this->daemonToken}",
                'Accept' => 'Application/vnd.pterodactyl.v1+json'
            ],
        ]);

        return $response->toArray();
    }
}
