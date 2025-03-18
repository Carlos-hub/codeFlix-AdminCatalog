<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Core\UseCase\Category\ListCategoriesUseCase;
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
                    'lastPage' => $response->lastPage,
                    'firstPage' => $response->firstPage,
                    'perPage' => $response->perPage,
                    'to' => $response->to,
                    'from' => $response->from,
                ]
            ]);
    }
}
