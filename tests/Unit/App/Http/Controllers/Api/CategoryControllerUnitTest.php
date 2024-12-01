<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\List\ListCategoriesOutputDTO;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;
use App\Http\Controllers\Api\CategoryController;

class CategoryControllerUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_Index()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')
            ->andReturn('teste');

        $listCategoriesDTOMock = Mockery::mock(ListCategoriesOutputDTO::class,
            [
                [], 1,1,1,1,1,1
            ]);
        $mockUseCase = Mockery::mock(ListCategoriesUseCase::class);
        $mockUseCase->shouldReceive('execute')
            ->andReturn($listCategoriesDTOMock);

        $controller = new CategoryController();

        $response  = $controller->index($mockRequest,$mockUseCase);
        dump($response);
        $this->assertIsObject($response->resource);
        $this->assertArrayHasKey('meta',$response->additional);
    }
}
