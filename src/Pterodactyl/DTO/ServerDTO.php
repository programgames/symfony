<?php

namespace App\Pterodactyl\DTO;

readonly class ServerDTO
{
    public function __construct(
        public int $id,
        public ?string $externalId,
        public string $uuid,
        public string $identifier,
        public string $name,
        public string $description,
        public ?string $status,
        public bool $suspended,
        public ServerLimitsDTO $limits,
        public ServerFeatureLimitsDTO $featureLimits,
        public int $user,
        public int $node,
        public int $allocation,
        public int $nest,
        public int $egg,
        public ServerContainerDTO $container,
        public \DateTimeImmutable $updatedAt,
        public \DateTimeImmutable $createdAt,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $attributes = $data['attributes'];

        return new self(
            id: $attributes['id'],
            externalId: $attributes['external_id'],
            uuid: $attributes['uuid'],
            identifier: $attributes['identifier'],
            name: $attributes['name'],
            description: $attributes['description'],
            status: $attributes['status'],
            suspended: $attributes['suspended'],
            limits: ServerLimitsDTO::fromArray($attributes['limits']),
            featureLimits: ServerFeatureLimitsDTO::fromArray($attributes['feature_limits']),
            user: $attributes['user'],
            node: $attributes['node'],
            allocation: $attributes['allocation'],
            nest: $attributes['nest'],
            egg: $attributes['egg'],
            container: ServerContainerDTO::fromArray($attributes['container']),
            updatedAt: new \DateTimeImmutable($attributes['updated_at']),
            createdAt: new \DateTimeImmutable($attributes['created_at']),
        );
    }
}
