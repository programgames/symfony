<?php

namespace App\Pterodactyl\DTO;

readonly class ServerLimitsDTO
{
    public function __construct(
        public int $memory,
        public int $swap,
        public int $disk,
        public int $io,
        public int $cpu,
        public ?string $threads,
        public bool $oomDisabled,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            memory: $data['memory'],
            swap: $data['swap'],
            disk: $data['disk'],
            io: $data['io'],
            cpu: $data['cpu'],
            threads: $data['threads'],
            oomDisabled: $data['oom_disabled'],
        );
    }
}
