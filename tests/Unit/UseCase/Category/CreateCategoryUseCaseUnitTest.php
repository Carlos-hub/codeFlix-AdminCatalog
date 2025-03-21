<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;

use Core\UseCase\DTO\Category\create\CategoryCreateInputDTO;
use Core\UseCase\DTO\Category\create\CategoryCreateOutputDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

/**
 * @property CategoryCreateInputDTO|(CategoryCreateInputDTO&Mockery\MockInterface&object&Mockery\LegacyMockInterface)|(Mockery\MockInterface&object&Mockery\LegacyMockInterface)|string[]|(\string[]&Mockery\MockInterface&object&Mockery\LegacyMockInterface) $mockInputDto
 * @property CategoryRepositoryInterface|(CategoryRepositoryInterface&Mockery\MockInterface&object&Mockery\LegacyMockInterface)|(Mockery\MockInterface&object&Mockery\LegacyMockInterface)|stdClass|(stdClass&Mockery\MockInterface&object&Mockery\LegacyMockInterface) $mockRepo
 * @property CategoryRepositoryInterface|(CategoryRepositoryInterface&Mockery\MockInterface&Mockery\LegacyMockInterface)|(Mockery\MockInterface&Mockery\LegacyMockInterface)|stdClass|(stdClass&Mockery\MockInterface&Mockery\LegacyMockInterface) $spy
 */
class CreateCategoryUseCaseUnitTest extends TestCase
{
    /**
     * @throws EntityValidationException
     */
    public function testCreateNewCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'name cat';

        $this->mockEntity = Mockery::mock(Category::class, [
            $categoryName,
            $uuid,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CategoryCreateInputDTO::class, [
            $categoryName,
        ]);

        $useCase = new CreateCategoryUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryCreateOutputDTO::class, $responseUseCase);
        $this->assertEquals($categoryName, $responseUseCase->name);
        $this->assertEquals('', $responseUseCase->description);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);
        $useCase = new CreateCategoryUseCase($this->spy);
        $responseUseCase = $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('insert');

        Mockery::close();
    }
}
