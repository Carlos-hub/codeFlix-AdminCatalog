<?php
namespace Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\List\ListCategoriesInputDTO;
use Core\UseCase\DTO\Category\List\ListCategoriesOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListCategoriesUseCaseUnitTest extends TestCase
{
    public function testListCategoriesEmpty()
    {
        $this->mockPagination = Mockery::mock(\stdClass::class, PaginationInterface::class);
        $this->mockPagination->shouldReceive('items')->andReturn([]);


        $this->mockRepo = Mockery::mock(\stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn([]);

        $this->mockInputDTO = Mockery::mock(ListCategoriesInputDTO::class,['id','filter']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInputDTO);

        $this->assertCount(0, $response->items());
        $this->assertInstanceOf(ListCategoriesOutputDTO::class, $response);
    }
}