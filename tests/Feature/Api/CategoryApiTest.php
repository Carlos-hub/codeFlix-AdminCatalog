<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        dump($response);
        $response->assertStatus(200);
    }
}
