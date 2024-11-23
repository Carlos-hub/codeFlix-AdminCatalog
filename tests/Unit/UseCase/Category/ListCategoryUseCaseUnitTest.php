<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category as CategoryEntity;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\List\CategoryInputDTO;
use Core\UseCase\DTO\Category\List\CreateOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

/**
 * @property CategoryEntity|(CategoryEntity&Mockery\MockInterface&object&Mockery\LegacyMockInterface)|(Mockery\MockInterface&object&Mockery\LegacyMockInterface)|string[]|(\string[]&Mockery\MockInterface&object&Mockery\LegacyMockInterface) $mockEntity
 * @property CategoryRepositoryInterface|(CategoryRepositoryInterface&Mockery\MockInterface&object&Mockery\LegacyMockInterface)|(Mockery\MockInterface&object&Mockery\LegacyMockInterface)|stdClass|(stdClass&Mockery\MockInterface&object&Mockery\LegacyMockInterface) $mockRepo
 * @property CategoryInputDTO|(CategoryInputDTO&Mockery\MockInterface&object&Mockery\LegacyMockInterface)|(Mockery\MockInterface&object&Mockery\LegacyMockInterface)|string[]|(\string[]&Mockery\MockInterface&object&Mockery\LegacyMockInterface) $mockInputDto
 * @property CategoryRepositoryInterface|(CategoryRepositoryInterface&Mockery\MockInterface&Mockery\LegacyMockInterface)|(Mockery\MockInterface&Mockery\LegacyMockInterface)|stdClass|(stdClass&Mockery\MockInterface&Mockery\LegacyMockInterface) $spy
 */
class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $id = (string) Uuid::uuid4()->toString();

        $this->mockEntity = Mockery::mock(CategoryEntity::class, [
            'teste category',
            $id,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')
                        ->with($id)
                        ->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CategoryInputDTO::class, [
            $id,
        ]);

        $useCase = new ListCategoryUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CreateOutputDTO::class, $response);
        $this->assertEquals('teste category', $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);
        $useCase = new ListCategoryUseCase($this->spy);
        $response = $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('findById');
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
