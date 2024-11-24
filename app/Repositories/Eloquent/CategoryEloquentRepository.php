<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Presetters\PaginationPreSetters;
use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use App\Models\Category as CategoryModel;

class CategoryEloquentRepository implements CategoryRepositoryInterface
{
    protected CategoryModel $model;
    public function __construct(CategoryModel $model)
    {
        $this->model = $model;
    }

    /**
     * @throws EntityValidationException
     */
    public function insert(Category $entity): Category
    {
        $category = $this->model->create([
            'id' => $entity->id(),
            'name' => $entity->name,
            'description' => $entity->description,
            'is_active' => $entity->isActive,
            'created_at' => $entity->createdAt(),
        ]);

        return $this->toCategory($category);
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        return [];
    }

    public function findById(string $id): Category
    {
       return new Category('teste');
    }

    public function paginate(string $filter = '', int $page = 1, $order = 'DESC', int $total = 15): PaginationInterface
    {
        return new PaginationPreSetters();
    }

    public function update(Category $category): Category
    {
       return new Category('teste');
    }

    public function delete(string $id): bool
    {
        return true;
    }

    /**
     * @throws EntityValidationException
     */
    private function toCategory(object $object): Category
    {
        return new Category(
            name: $object->name,
            id: $object->id,
            description: $object->description,
        );
    }
}
