<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\List\ListCategoriesInputDTO;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, ListCategoriesUseCase $listCategoriesUseCase)
    {
        $response = $listCategoriesUseCase->execute(
            inputDTO: new ListCategoriesInputDTO(
                filter: $request->get('filter') ?? '',
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page'),
                totalPerPage: (int) $request->get('totalPerPage', 15)
            )
        );



        return CategoryResource::collection(collect($response->items))
            ->additional([
                'meta' => [
                    'total' => $response->total,
                    'currentPage' => $response->currentPage,
                    'lastPage' => $response->lastPage,
                    'firstPage' => $response->firstPage,
                    'perPage' => $response->perPage,
                    'to' => $response->to,
                    'from' => $response->from,
                ]
            ]);
    }


    public function show(ListCategoryUseCase $useCase, $id)
    {
        $category = $useCase->execute(new CategoryInputDto($id));

        return (new CategoryResource($category))->response();
    }

    public function update(UpdateCategoryRequest $request, UpdateCategoryUseCase $useCase, $id)
    {
        $response = $useCase->execute(
            input: new CategoryUpdateInputDto(
                id: $id,
                name: $request->name,
            )
        );

        return (new CategoryResource($response))
            ->response();
    }

    public function destroy(DeleteCategoryUseCase $useCase, $id)
    {
        $useCase->execute(new CategoryInputDto($id));

        return response()->noContent();
    }
}
