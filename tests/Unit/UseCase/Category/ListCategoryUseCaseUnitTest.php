<?php

namespace Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\List\CategoryInputDTO;
use Core\UseCase\DTO\Category\List\CreateOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetCategoryById()
    {
        $id = Uuid::uuid4()->toString();
        $this->mockEntity = Mockery::mock(Category::class,[
            'Category Test',
            $id,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class,CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')
            ->with($id)
            ->andReturn($this->mockEntity);
        $this->mockInputDTO = Mockery::mock(stdClass::class, CategoryInputDTO::class,[
            $id,
        ]);
        $useCase = new ListCategoryUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CreateOutputDTO::class, $response);

        $this->assertEquals('Category Test', $response->name);
        $this->assertEquals($id, $response->id);

        /**
         *  Spies
         */
        $this->spy = Mockery::spy(stdClass::class,CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);

        $useCase = new ListCategoryUseCase($this->spy);
        $response = $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived('findById');
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}