<?php

namespace Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\update\UpdateCategoryInputDTO;
use Core\UseCase\DTO\Category\update\UpdateCategoryOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateUseCaseCategoryUnitTest extends TestCase
{
    public function testUpdateNameCategoryUseCase()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = "Category Update Test";
        $categoryDesc = "Category Update Description Test";
        $this->mockEntity = Mockery::mock(Category::class,[ $categoryName, $uuid, $categoryDesc ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockEntity->shouldReceive('update');


        $this->mockRepo = Mockery::mock(\stdClass::class,CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->andReturn($this->mockEntity);


        $this->mockInputDTO = Mockery::mock(UpdateCategoryInputDTO::class,[
            $uuid,
            'new Name Category',
            'new Description Category',
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(UpdateCategoryOutputDTO::class, $responseUseCase);

        /**
         * Spies
         */

        $this->spy = Mockery::spy(\stdClass::class,CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);

        $useCase = new UpdateCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('update');
        Mockery::close();
    }
}