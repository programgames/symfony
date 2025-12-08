<?php

namespace App\Controller;

use App\Pterodactyl\DTO\AllocationListResponseDTO;
use App\Pterodactyl\DTO\ServerListResponseDTO;
use App\Pterodactyl\PterodactylApiClient;
use App\Wings\WingsApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PterodactylController extends AbstractController
{
    #[Route('/pterodactyl', name: 'app_pterodactyl')]
    public function index(): Response
    {
        return $this->render('pterodactyl/index.html.twig', [
            'controller_name' => 'PterodactylController',
        ]);
    }

    #[Route('/servers', name: 'servers')]
    public function serversAction(PterodactylApiClient $apiClient, WingsApiClient $wingsApiClient): Response
    {
        /////////////////
        $serversFormatted = [];

        $serversResponse = $apiClient->adminRequest('/servers');
        $serverList = ServerListResponseDTO::fromArray($serversResponse);
        foreach ($serverList->servers as $server) {
            $allocationsResponse = $apiClient->clientRequest('/servers/' . $server->identifier . '/network/allocations');
            $wingServerStatus = $wingsApiClient->wingsRequest('hpZBOcQXyK5abUQhpQ4HDkBU3twZVuEfJ9wQOyvSq6SEb8p1wnKKofN1JwKpVpH3','/api/servers/' . $server->uuid);
            $state = $wingServerStatus['state'];
            $allocationList = AllocationListResponseDTO::fromArray($allocationsResponse);

            $defaultAllocation = $allocationList->allocations[0] ?? null;
            $port = $defaultAllocation?->port;

            $serversFormatted[] = [
                'state' => $state,
                'name' => $server->name,
                'memoryLimit' => $server->limits->memory,
                'diskLimit' => $server->limits->disk,
                'port' => $port,
                'url' => $port ? 'multimod.ovh:' . $port : null,
            ];
        }

        return $this->render('pterodactyl/servers.html.twig', [
            'data' => $serversFormatted
        ]);
    }
}
