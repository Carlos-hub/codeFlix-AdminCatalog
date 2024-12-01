<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Presetters\PaginationPreSetters;
use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Exception\NotFoundException;
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
        $categories =  $this->model
            ->where(function ($query) use ($filter) {
                if($filter !== '') {
                    $query->where('name', 'LIKE', "%{$filter}%");
                }
            })
            ->orderBy('id', $order)
            ->get();

        return $categories->toArray();
    }

    public function findById(string $id): Category
    {
       if(!$category = $this->model->find($id)){
           throw new NotFoundException('Category not found');
       }
       return $this->toCategory($category);
    }

    public function paginate(string $filter = '', int $page = 1, $order = 'DESC', int $total = 15): PaginationInterface
    {

        $query = $this->model;
        if($filter !== '') {
            $query = $query->where('name', 'LIKE', "%{$filter}%");
        }
        $query->orderBy('id', $order);
        $paginator = $query->paginate();



        return new PaginationPreSetters($paginator);
    }

    public function update(Category $category): Category
    {

        if (!$categoryFound = $this->model->find($category->id)) {
            throw new NotFoundException('Category not found');
        }
        $categoryFound->update([
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
        ]);
        $categoryFound->refresh();

       return $this->toCategory($categoryFound);
    }

    public function delete(string $id): bool
    {
        if (!$category = $this->model->find($id)) {
            throw new NotFoundException('Category not found');
        }
        return $category->delete();
    }

    /**
     * @throws EntityValidationException
     */
    private function toCategory(object $object): Category
    {
        $entity =  new Category(
            name: $object->name,
            id: $object->id,
            description: $object->description ?? '',
        );
        ((bool) $entity->isActive) ? $entity->activated() : $entity->disabled();

        return $entity;
    }
}
