<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\List\ListCategoriesInputDTO;
use Core\UseCase\DTO\Category\List\ListCategoriesOutputDTO;

class ListCategoriesUseCase
{
    protected $repository;
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ListCategoriesInputDTO $inputDTO): ListCategoriesOutputDTO
    {
        $categories = $this->repository->paginate(
            filter: $inputDTO->filter,
            page: $inputDTO->page,
            order: $inputDTO->order,
            total: $inputDTO->totalPerPage
        );

        return new ListCategoriesOutputDTO(
            total: $categories->total(),
        );
    }
}