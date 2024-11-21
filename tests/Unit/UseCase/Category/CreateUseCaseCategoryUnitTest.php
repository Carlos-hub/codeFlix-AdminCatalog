<?php

namespace Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\create\CategoryCreateInputDTO;
use Core\UseCase\DTO\Category\create\CategoryCreateOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

class CreateUseCaseCategoryUnitTest extends TestCase
{
    public function testCreateNewCategoryUseCase()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = "Category Test";
        $this->mockEntity = Mockery::mock(Category::class,[$categoryName,$uuid
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(\stdClass::class,CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInputDTO = Mockery::mock(CategoryCreateInputDTO::class,[
            $categoryName,
        ]);
        $useCase = new CreateCategoryUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryCreateOutputDTO::class, $responseUseCase);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(\stdClass::class,CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);

        $useCase = new CreateCategoryUseCase($this->spy);
        $responseUseCase = $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived("insert");

        Mockery::close();
    }
}