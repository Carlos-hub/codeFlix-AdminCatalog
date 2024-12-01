<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\List\CategoryInputDTO;
use Core\UseCase\DTO\Category\List\ListCategoriesInputDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListCategoryCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ListOneCategory()
    {
        $category = ModelCategory::factory()->create();
        $repository = new CategoryEloquentRepository(new ModelCategory());
        $useCase = new ListCategoryUseCase($repository);

        $response = $useCase->execute(
            new CategoryInputDTO(id: $category->id)
        );

        $this->assertEquals($category->id, $response->id);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);


    }
}
