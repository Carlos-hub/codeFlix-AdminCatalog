<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\delete\DeleteCategoryOutputDTO;
use Core\UseCase\DTO\Category\List\CategoryInputDTO;

class DeleteCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryInputDTO $inputDTO): DeleteCategoryOutputDTO
    {

        $responseDelete =  $this->repository->delete($inputDTO->id);
        return new DeleteCategoryOutputDTO(
            success: $responseDelete
        );
    }
}
