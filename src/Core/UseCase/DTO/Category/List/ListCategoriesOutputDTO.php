<?php

namespace Core\UseCase\DTO\Category\List;

class ListCategoriesOutputDTO
{
//string $filter = '', int $page = 1, $order = 'DESC', int $total = 15
    public function __construct(
        protected int $total
    ){}
}