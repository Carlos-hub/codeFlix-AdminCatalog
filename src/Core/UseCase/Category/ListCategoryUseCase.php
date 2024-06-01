<?php
namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\List\CategoryInputDTO;
use Core\UseCase\DTO\Category\List\CreateOutputDTO;

class ListCategoryUseCase
{
    protected $repository;
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryInputDTO $inputDTO): CreateOutputDTO
    {
        $category = $this->repository->findById($inputDTO->id);

        return new CreateOutputDTO(
            id: $category->id(),
            name: $category->name,
            description: $category->description,
            isActive: $category->isActive
        );
    }

}