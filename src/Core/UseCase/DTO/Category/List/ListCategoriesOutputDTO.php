<?php

namespace Core\UseCase\DTO\Category\List;

class ListCategoriesOutputDTO
{
    public function __construct(
        public array $items,
        public int $total,
        public int $lastPage,
        public int $firstPage,
        public int $perPage,
        public int $to,
        public int $from,
    ){}
}