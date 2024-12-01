<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\List\CategoryInputDTO;
use Core\UseCase\DTO\Category\update\UpdateCategoryInputDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoryCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_UpdateCategory()
    {
        $category = ModelCategory::factory()->create();
        $repository = new CategoryEloquentRepository(new ModelCategory());
        $useCase = new UpdateCategoryUseCase($repository);

        $response = $useCase->execute(
            new UpdateCategoryInputDTO(
                id: $category->id,name: 'new name', description: 'new description')
        );

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'new name', 'description' => 'new description']);
        $this->assertNotEquals($category->name, $response->name);
    }
}
