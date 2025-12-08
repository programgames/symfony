<?php

namespace App\Controller;

use App\Pterodactyl\PterodactylApiClient;
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
    public function serversAction(PterodactylApiClient $apiClient): Response
    {
        $servers = $apiClient->clientRequest('');
        $serversFormatted = [];

        foreach ($servers['data'] as $server) {
            $serversFormatted[] = [
                'name' => $server['attributes']['name'],
                'memory' => $server['attributes']['limits']['memory'],
                'port' => $server['attributes']['relationships']['allocations']['data'][0]['attributes']['port'],
                'url' => 'multimod.ovh:' . $server['attributes']['relationships']['allocations']['data'][0]['attributes']['port'],
            ];
        }
        return $this->render('pterodactyl/servers.html.twig', [
            'data' => $serversFormatted
        ]);
    }
}
