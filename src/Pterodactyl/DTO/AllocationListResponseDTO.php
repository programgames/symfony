<?php

namespace App\Pterodactyl\DTO;

readonly class AllocationListResponseDTO
{
    /**
     * @param AllocationDTO[] $allocations
     */
    public function __construct(
        public string $object,
        public array $allocations,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $allocations = array_map(
            fn(array $allocationData) => AllocationDTO::fromArray($allocationData),
            $data['data']
        );

        return new self(
            object: $data['object'],
            allocations: $allocations,
        );
    }
}
