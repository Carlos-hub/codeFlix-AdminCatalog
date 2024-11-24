<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryEloquentRepositoryTest extends TestCase
{
    /**
     * A basic feature test insert.
     *
     * @return void
     */
    public function testInsert()
    {
        $repository = new CategoryEloquentRepository(new CategoryModel());

        $categoryentity = new EntityCategory( name: 'test', description: 'test_description');
        $response = $repository->insert($categoryentity);

        $this->assertInstanceOf(CategoryRepositoryInterface::class, $repository);
        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertDatabaseHas('categories', ['name' => 'test']);
    }
}
