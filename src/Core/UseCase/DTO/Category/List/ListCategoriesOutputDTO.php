<?php

namespace Core\UseCase\DTO\Category\List;

class ListCategoriesOutputDTO
{
    public function __construct(
        public int $total,
        public array  $items = [],
    ){}
}