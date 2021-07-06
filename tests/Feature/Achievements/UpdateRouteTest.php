<?php

namespace Tests\Feature\Achievements;

use Tests\TestCase;
use App\Models\Achievement;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateRouteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * @return void
     */
    public function test_validation()
    {
        $achievement = Achievement::create([
            'name' => 'NAME!',
            'expression' => 'EXPRESSION!'
        ]);

        $response = $this->put(
            "/api/achievements/{$achievement->id}",
            [],
            ['Accept' => 'application/json']);

        $response
            ->assertStatus(400)
            ->assertSee([
                'status' => 'error',
                'message' => 'No data to update!'
            ]);

        $response = $this->put(
            "/api/achievements/{$achievement->id}",
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

        $response = $this->put(
            "/api/achievements/{$achievement->id}",
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

        $response = $this->put(
            "/api/achievements/{$achievement->id}",
            [
                'expression' => 'rogue.delete()'
            ],
            ['Accept' => 'application/json']
        );

        $response
            ->assertStatus(422)
            ->assertSee(['message' => 'The given data was invalid'])
            ->assertSee([
                'expression' => 'Expression language statement must not contain save, update, create, make, delete and push keywords for safety reasons!'
            ]);
    }

    /**
     * @test
     */
    public function test_if_store_route_is_ok()
    {
        $achievement = Achievement::create([
            'name' => 'NAME',
            'slug' => 'SLUG',
            'description' => 'DESCRIPTION',
            'expression' => 'EXPRESSION'
        ]);

        $response = $this->put(
            "/api/achievements/{$achievement->id}",
            [
                'name' => 'NAME',
                'slug' => 'SLUG-NEW',
                'description' => 'DESCRIPTION',
                'expression' => 'EXPRESSION-NEW'
            ],
            ['Accept' => 'application/json']
        );

        $response
            ->assertStatus(200)
            ->assertSee([
                'name' => 'NAME',
                'slug' => 'SLUG-NEW',
                'description' => 'DESCRIPTION',
                'expression' => 'EXPRESSION-NEW'
            ]);

        $this->assertDatabaseHas(Achievement::class, [
            'name' => 'NAME',
            'slug' => 'SLUG-NEW',
            'description' => 'DESCRIPTION',
            'expression' => 'EXPRESSION-NEW'
        ]);
    }
}
