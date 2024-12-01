<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\create\CategoryCreateInputDTO;
use Core\UseCase\DTO\Category\create\CategoryCreateOutputDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {

        $repository = new CategoryEloquentRepository(new ModelCategory());
        $useCase = new CreateCategoryUseCase($repository);

        $responseUseCase = $useCase->execute(
            new CategoryCreateInputDTO(
                'name cat',
                'description cat',
                true
            )
        );

        $this->assertEquals('name cat', $responseUseCase->name);
        $this->assertNotEmpty($responseUseCase->id);

        $this->assertDatabaseHas('categories', [
            'id' => $responseUseCase->id,
        ]);

    }
}
