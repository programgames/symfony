<?php

namespace App\Pterodactyl\DTO;

readonly class AllocationDTO
{
    public function __construct(
        public int $id,
        public string $ip,
        public ?string $ipAlias,
        public int $port,
        public ?string $notes,
        public bool $isDefault,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $attributes = $data['attributes'];

        return new self(
            id: $attributes['id'],
            ip: $attributes['ip'],
            ipAlias: $attributes['ip_alias'],
            port: $attributes['port'],
            notes: $attributes['notes'],
            isDefault: $attributes['is_default'],
        );
    }
}
