<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthController
{
    public function __construct(
        private Connection $connection
    ) {}

    #[Route('/health', name: 'health', methods: ['GET'])]
    public function health(): JsonResponse
    {
        try {
            // Check database
            $this->connection->executeQuery('SELECT 1');

            return new JsonResponse([
                'status' => 'healthy',
                'timestamp' => time(),
                'services' => [
                    'database' => 'ok',
                ]
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
