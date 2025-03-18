<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;


class CategoryApiTest extends TestCase
{
    protected $endpoint = '/api/categories';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_empty_categories()
    {
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);
    }

    public function test_list_all_categories()
    {
        Category::factory()->count(30)->create();

        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'currentPage',
                'lastPage',
                'firstPage',
                'perPage',
                'to',
                'from',
            ],
        ]);
    }

    public function test_list_all_categories_paginate()
    {
        Category::factory()->count(30)->create();

        $response = $this->getJson("$this->endpoint?page=2");
        $response->assertStatus(200);
        $result = [
            'total' => 30,
            'currentPage' => 2,
            'lastPage' => 2,
            'firstPage' => 16,
            'perPage' => 15,
            'to' => 16,
            'from' => 30,
        ];
        $expected = $response->json('meta');
        self::assertEquals($result,$expected);
    }

    public function test_list_category_not_found()
    {
        $response = $this->getJson("{$this->endpoint}/fake_value");
        $response->dump();
        $response->assertStatus(ResponseAlias::HTTP_NOT_FOUND);
    }
}
