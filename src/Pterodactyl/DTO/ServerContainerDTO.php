<?php

namespace App\Pterodactyl\DTO;

readonly class ServerContainerDTO
{
    public function __construct(
        public string $startupCommand,
        public string $image,
        public int $installed,
        public array $environment,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            startupCommand: $data['startup_command'],
            image: $data['image'],
            installed: $data['installed'],
            environment: $data['environment'],
        );
    }
}
