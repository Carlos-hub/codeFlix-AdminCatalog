<?php

namespace Core\UseCase\DTO\Category\List;

class ListCategoriesInputDTO
{
//string $filter = '', int $page = 1, $order = 'DESC', int $total = 15
    public function __construct(
        public string $filter = '',
        public string $order = 'DESC',
        public int $page = 1,
        public int $totalPerPage = 15,
    ){}
}