<?php

namespace App\Controller;

use App\Minecraft\MinecraftServerPing;
use App\Pterodactyl\DTO\AllocationListResponseDTO;
use App\Pterodactyl\DTO\ServerDTO;
use App\Pterodactyl\DTO\ServerListResponseDTO;
use App\Pterodactyl\PterodactylApiClient;
use App\Service\CurseForgeService;
use App\Wings\WingsApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

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
    public function serversAction(
        PterodactylApiClient $apiClient,
        WingsApiClient $wingsApiClient,
        CurseForgeService $curseForgeService,
        MinecraftServerPing $minecraftPing,
    ): Response {
        $serversFormatted = [];

        $serversResponse = $apiClient->adminRequest('/servers?include=egg,nest');
        $serverList = ServerListResponseDTO::fromArray($serversResponse);
        foreach ($serverList->servers as $server) {
            $allocationsResponse = $apiClient->clientRequest('/servers/' . $server->identifier . '/network/allocations');
            try {
                $wingServerStatus = $wingsApiClient->wingsRequest('/api/servers/' . $server->uuid);
            } catch (ExceptionInterface) {
                $wingServerStatus = [];
            }
            $state = $wingServerStatus['state'] ?? 'offline';
            $usage = $wingServerStatus['utilization'] ?? [];
            $allocationList = AllocationListResponseDTO::fromArray($allocationsResponse);

            $defaultAllocation = $allocationList->allocations[0] ?? null;
            $port = $defaultAllocation?->port;

            $isMinecraft = $this->isMinecraft($server);
            $minecraft = null;
            if ($isMinecraft && $state === 'running' && $defaultAllocation && $defaultAllocation->ip !== '0.0.0.0') {
                $minecraft = $minecraftPing->ping($defaultAllocation->ip, $defaultAllocation->port);
            }

            // CurseForge n'a de sens que pour un modpack : pas pour les autres jeux, les vanilla de mcbot,
            // ni un serveur qui répond au ping sans aucun mod
            $modpackInfo = null;
            $isVanilla = str_starts_with($server->externalId ?? '', 'mcbot-')
                || stripos($server->eggName ?? '', 'vanilla') !== false
                || ($minecraft && !$minecraft['modLoader']);
            if ($isMinecraft && !$isVanilla) {
                $modpackInfo = $curseForgeService->findModpackUrl($server->name);
            }

            $running = $state !== 'offline';
            $serversFormatted[] = [
                'state' => $state,
                'name' => $server->name,
                // mcbot range ses métadonnées (« mcbot creator=… version=… ») à la fin de la description
                'description' => trim(preg_replace('/\s*—?\s*mcbot\s.*$/s', '', $server->description)),
                'game' => $isMinecraft ? 'Minecraft' : ($server->eggName ?? $server->nestName),
                'egg' => $server->eggName,
                'java' => preg_match('/java[_-]?(\d+)/i', $server->container->image, $m) ? (int) $m[1] : null,
                'memoryLimit' => $server->limits->memory,
                'diskLimit' => $server->limits->disk,
                'cpuLimit' => $server->limits->cpu,
                // Wings garde la dernière mesure d'un serveur éteint : on ne l'affiche que s'il tourne
                'memoryUsed' => $running && isset($usage['memory_bytes']) ? $usage['memory_bytes'] / 1048576 : null,
                'cpuUsed' => $running && isset($usage['cpu_absolute']) ? $usage['cpu_absolute'] : null,
                'diskUsed' => isset($usage['disk_bytes']) ? $usage['disk_bytes'] / 1048576 : null,
                'uptime' => $running && !empty($usage['uptime']) ? $this->formatDuration(intdiv($usage['uptime'], 1000)) : null,
                'port' => $port,
                'url' => $port ? 'multimod.ovh:' . $port : null,
                'minecraft' => $minecraft,
                'modpack' => $modpackInfo,
            ];
        }

        // Serveurs en ligne d'abord (tri stable : l'ordre Pterodactyl est conservé au sein de chaque groupe)
        usort($serversFormatted, fn (array $a, array $b) => ($a['state'] === 'offline') <=> ($b['state'] === 'offline'));

        return $this->render('pterodactyl/servers.html.twig', [
            'data' => $serversFormatted
        ]);
    }

    private function isMinecraft(ServerDTO $server): bool
    {
        return stripos($server->nestName ?? '', 'minecraft') !== false
            || stripos($server->container->image, 'java') !== false;
    }

    private function formatDuration(int $seconds): string
    {
        $days = intdiv($seconds, 86400);
        $hours = intdiv($seconds % 86400, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        return match (true) {
            $days > 0 => sprintf('%d j %d h', $days, $hours),
            $hours > 0 => sprintf('%d h %02d', $hours, $minutes),
            default => sprintf('%d min', $minutes),
        };
    }
}
