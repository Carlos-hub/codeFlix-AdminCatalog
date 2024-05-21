<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    public function insert(Category $category): Category;
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function findById(string $id): Category;
    public function paginate(string $filter = '', int $page = 1, $order = 'DESC', int $total = 15): array;
    public function update(Category $category): Category;
    public function delete(string $id): bool;
    public  function toCategory(object $data): Category;
}