<?php

namespace App\Pterodactyl\DTO;

readonly class ServerFeatureLimitsDTO
{
    public function __construct(
        public int $databases,
        public int $allocations,
        public int $backups,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            databases: $data['databases'],
            allocations: $data['allocations'],
            backups: $data['backups'],
        );
    }
}
