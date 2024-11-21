<?php

namespace Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\delete\DeleteCategoryOutputDTO;
use Core\UseCase\DTO\Category\List\CategoryInputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteUseCaseCategoryUnitTest extends TestCase
{
    public function testDeleteCategoryUseCase()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->mockRepo = Mockery::mock(\stdClass::class,CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('delete')->andReturn(true);

        $this->mockInputDTO = Mockery::mock(CategoryInputDTO::class,[ $uuid]);
        $useCase = new  DeleteCategoryUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(DeleteCategoryOutputDTO::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);
    }
}