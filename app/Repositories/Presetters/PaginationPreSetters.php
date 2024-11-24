<?php

namespace App\Repositories\Presetters;

use Core\Domain\Repository\PaginationInterface;

class PaginationPreSetters implements PaginationInterface
{

    public function items(): array
    {
        return [];
    }

    public function total(): int
    {
        return 1;
    }

    public function lastPage(): int
    {
        return 1;
    }

    public function firstPage(): int
    {
        return 1;
    }

    public function currentPage(): int
    {
        return 1;
    }

    public function perPage(): int
    {
        return 1;
    }

    public function to(): int
    {
        return 1;
    }

    public function from(): int
    {
        return 1;
    }
}
