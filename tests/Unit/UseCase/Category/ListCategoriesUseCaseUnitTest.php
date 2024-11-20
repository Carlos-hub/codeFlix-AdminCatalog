<?php
namespace Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\List\ListCategoriesInputDTO;
use Core\UseCase\DTO\Category\List\ListCategoriesOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListCategoriesUseCaseUnitTest extends TestCase
{
    public function testListCategoriesEmpty()
    {
        $mockPagination = $this->mockPagination();
        $this->mockRepo = Mockery::mock(\stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $this->mockInputDTO = Mockery::mock(ListCategoriesInputDTO::class,['filter','desc']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInputDTO);

        $this->assertCount(0, $response->items);
        $this->assertInstanceOf(ListCategoriesOutputDTO::class, $response);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $useCase = new ListCategoriesUseCase($this->spy);
        $this->spy->shouldReceive('paginate')->andReturn($mockPagination);
        $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived('paginate');
    }

    public function testListCategories()
    {
        $register = new \stdClass();
        $register->id = 'asdfasdfasdf';
        $register->name = 'Category Test';
        $register->description = 'Description Test';
        $register->is_active = true;
        $register->created_at = 'created_at';
        $register->updated_at = 'updated_at';
        $register->deleted_at = 'deleted_at';
        $mockPagination = $this->mockPagination([$register]);
        $this->mockRepo = Mockery::mock(\stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $this->mockInputDTO = Mockery::mock(ListCategoriesInputDTO::class,['filter','desc']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInputDTO);

        $this->assertCount(1, $response->items);
        $this->assertInstanceOf(stdClass::class, $response->items[0]);
        $this->assertInstanceOf(ListCategoriesOutputDTO::class, $response);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $useCase = new ListCategoriesUseCase($this->spy);
        $this->spy->shouldReceive('paginate')->andReturn($mockPagination);
        $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived('paginate');
    }

    protected function mockPagination(array $items = [], int $total = 0, int $lastPage = 0, int $firstPage = 1, int $perPage = 15, int $to = 0, int $from = 0): PaginationInterface
    {
        $this->mockPagination = Mockery::mock(\stdClass::class, PaginationInterface::class);
        $this->mockPagination->shouldReceive('items')->andReturn($items);
        $this->mockPagination->shouldReceive('total')->andReturn($total);
        $this->mockPagination->shouldReceive('lastPage')->andReturn($lastPage);
        $this->mockPagination->shouldReceive('firstPage')->andReturn($firstPage);
        $this->mockPagination->shouldReceive('perPage')->andReturn($perPage);
        $this->mockPagination->shouldReceive('to')->andReturn($to);
        $this->mockPagination->shouldReceive('from')->andReturn($from);

        return $this->mockPagination;
    }
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}