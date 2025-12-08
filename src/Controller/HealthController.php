<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HealthController extends AbstractController
{
    public function __construct(
        private readonly Connection $connection
    ) {}

    #[Route('/health', name: 'app_health', methods: ['GET'])]
    public function index(): JsonResponse
    {
        try {
            // Check database
            $this->connection->executeQuery('SELECT 1');

            return $this->json([
                'status' => 'healthy',
                'timestamp' => time(),
                'services' => [
                    'database' => 'ok',
                ]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
