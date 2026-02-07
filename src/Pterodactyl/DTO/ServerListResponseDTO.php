<?php

namespace App\Pterodactyl\DTO;

readonly class ServerListResponseDTO
{
    /**
     * @param ServerDTO[] $servers
     */
    public function __construct(
        public string $object,
        public array $servers,
        public PaginationDTO $pagination,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $servers = array_map(
            fn(array $serverData) => ServerDTO::fromArray($serverData),
            $data['data']
        );

        return new self(
            object: $data['object'],
            servers: $servers,
            pagination: PaginationDTO::fromArray($data['meta']['pagination']),
        );
    }
}
