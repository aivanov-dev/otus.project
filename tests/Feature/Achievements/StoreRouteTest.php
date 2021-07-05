<?php

namespace Tests\Feature\Achievements;

use Tests\TestCase;
use App\Models\Achievement;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StoreRouteTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     *
     * @return void
     */
    public function test_validation()
    {
        $response = $this->post(
            '/api/achievements',
            [],
            ['Accept' => 'application/json']);

        $response
            ->assertStatus(422)
            ->assertSee(['message' => 'The given data was invalid'])
            ->assertSee([
                'name' => 'The name field is required',
                'expression' => 'The name field is required'
            ]);

        $response = $this->post(
            '/api/achievements',
            [
                'name' => 5,
                'expression' => 0
            ],
            ['Accept' => 'application/json']);

        $response
            ->assertStatus(422)
            ->assertSee(['message' => 'The given data was invalid'])
            ->assertSee([
                'name' => 'The name must be a string.',
                'expression' => 'The expression must be a string.'
            ]);

        $response = $this->post(
            '/api/achievements',
            [
                'name' => 5,
                'slug' => ['dsf', null],
                'description' => 333,
                'expression' => 0
            ],
            ['Accept' => 'application/json']
        );

        $response
            ->assertStatus(422)
            ->assertSee(['message' => 'The given data was invalid'])
            ->assertSee([
                'name' => 'The name must be a string.',
                'slug' => 'The slug must be a string.',
                'description' => 'The description must be a string.',
                'expression' => 'The expression must be a string.'
            ]);
    }

    /**
     * @test
     */
    public function test_if_store_route_is_ok()
    {
        $response = $this->post(
            '/api/achievements',
            [
                'name' => 'NAME',
                'slug' => 'SLUG',
                'description' => 'DESCRIPTION',
                'expression' => 'EXPRESSION'
            ],
            ['Accept' => 'application/json']
        );

        $response
            ->assertStatus(201)
            ->assertSee([
                "status" => "Success",
                "message" => "Achievement has been successfully created!"
            ]);

        $this->assertDatabaseHas(Achievement::class, [
            'name' => 'NAME',
            'slug' => 'SLUG',
            'description' => 'DESCRIPTION',
            'expression' => 'EXPRESSION'
        ]);
    }
}
