<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryEloquentRepositoryTest extends TestCase
{
    protected CategoryEloquentRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new CategoryEloquentRepository(new CategoryModel());
    }

    /**
     * A basic feature test insert.
     *
     * @return void
     */
    public function testInsert()
    {


        $categoryEntity = new EntityCategory( name: 'test', description: 'test_description');
        $response = $this->repository->insert($categoryEntity);

        $this->assertInstanceOf(CategoryRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertDatabaseHas('categories', ['name' => 'test']);
    }

    public function testFindById()
    {
        $category = CategoryModel::factory()->create();
        $response = $this->repository->findById($category->id);

        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertEquals($category->id, $response->id());
    }


    public function testFindByIdNotfound()
    {
        try{
            $uuid = (string) Str::uuid();
            $response = $this->repository->findById($uuid);
        }catch (\Throwable $e){
            $this->assertInstanceOf(NotFoundException::class, $e);
        }
    }

    public function testFindAll()
    {
        $categories = CategoryModel::factory()->count(10)->create();

        $response = $this->repository->findAll();
        $this->assertCount(count($categories), $response);
    }

    public function testPaginate()
    {
        $categories = CategoryModel::factory()->count(50)->create();

        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    public function testPaginateWithOutData()
    {
        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
    }

    public function testUpdateIdNotFound()
    {
        try{
            $category = new EntityCategory( name: 'test', description: 'test_description');
            $this->repository->findById($category->id());

        }catch (\Throwable $e){
            $this->assertInstanceOf(NotFoundException::class, $e);
        }
    }

    public function testUpdate()
    {
        $categoryDB = CategoryModel::factory()->create();
        $category = new EntityCategory(
            name: 'Updated Name',
            id: $categoryDB->id,
        );
        $response = $this->repository->update($category);

        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertNotEquals($response->name, $categoryDB->name);
        $this->assertEquals('Updated Name', $response->name);
    }

    public function testDeleteNotFound()
    {
        try{
            $uuid = (string) Str::uuid();
            $response = $this->repository->delete($uuid);
        }catch (\Throwable $e){
            $this->assertInstanceOf(NotFoundException::class, $e);
        }

    }
    public function testDelete()
    {
        $category = CategoryModel::factory()->create();
        $response = $this->repository->delete($category->id);

        $this->assertTrue($response);

    }
}
