<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\update\UpdateCategoryInputDTO;
use Core\UseCase\DTO\Category\update\UpdateCategoryOutputDTO;

class UpdateCategoryUseCase
{
    protected $repository;
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UpdateCategoryInputDTO $data) : UpdateCategoryOutputDTO
    {
        $category = $this->repository->findById($data->id);
        if ($category === null) {
            throw new \Exception('Category not found');
        }
        $category->update(
            name: $data->name,
            description: $data->description ?? $category->description,
        );

        $categoryUpdated = $this->repository->update($category);

        return new UpdateCategoryOutputDTO(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            description: $categoryUpdated->description,
            isActive: $categoryUpdated->isActive
        );
    }
}