<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\create\CategoryCreateInputDTO;
use Core\UseCase\DTO\Category\List\ListCategoriesInputDTO;
use Tests\TestCase;

class ListCategoriesCategoryUseCaseTest extends TestCase
{

    public function test_list_empty()
    {
        $responseUseCase = $this->createUseCase();
        $this->assertCount(0, $responseUseCase->items);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_all()
    {

        $categories = ModelCategory::factory(10)->create();
        $responseUseCase = $this->createUseCase();

        $this->assertCount(10, $responseUseCase->items);

    }

    protected function createUseCase()
    {
        $repository = new CategoryEloquentRepository(new ModelCategory());
        $useCase = new ListCategoriesUseCase($repository);

        return $useCase->execute(
            new ListCategoriesInputDTO()
        );
    }
}
