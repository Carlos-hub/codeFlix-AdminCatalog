<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\create\CategoryCreateInputDTO;
use Core\UseCase\DTO\Category\List\CategoryInputDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete()
    {
        $categoryDB = ModelCategory::factory()->create();
        $repository = new CategoryEloquentRepository(new ModelCategory());
        $useCase = new DeleteCategoryUseCase($repository);

        $responseUseCase = $useCase->execute(
            new CategoryInputDTO(
                id: $categoryDB->id
            )
        );

        $this->assertSoftDeleted('categories', [
            'id' => $categoryDB->id,
        ]);
    }
}
