<?php

namespace App\Pterodactyl\DTO;

readonly class PaginationDTO
{
    public function __construct(
        public int $total,
        public int $count,
        public int $perPage,
        public int $currentPage,
        public int $totalPages,
        public array $links,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            total: $data['total'],
            count: $data['count'],
            perPage: $data['per_page'],
            currentPage: $data['current_page'],
            totalPages: $data['total_pages'],
            links: $data['links'],
        );
    }
}
