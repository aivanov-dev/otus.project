<?php

namespace Tests\Feature\Achievements;

use Tests\TestCase;
use App\Models\Achievement;
use App\Http\Resources\AchievementCollection;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexRouteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * @return void
     */
    public function check_that_page_and_per_page_is_numeric_and_greater_than_0()
    {
        $response = $this->get('/api/achievements/index?page=sdf&per-page=sdfsdfds', ['Accept' => 'application/json']);
        $response->assertStatus(422)->assertSee(['message' => 'The given data was invalid']);

        $response = $this->get('/api/achievements/index?page=0&per-page=0', ['Accept' => 'application/json']);
        $response->assertStatus(422)->assertSee(['message' => 'The given data was invalid']);

        $response = $this->get('/api/achievements/index?page=-2&per-page=-1', ['Accept' => 'application/json']);
        $response->assertStatus(422)->assertSee(['message' => 'The given data was invalid']);
    }

    /**
     * @test
     */
    public function check_if_index_route_ok()
    {
        Achievement::create([
            'name' => 'NAME1',
            'slug' => 'SLUG1',
            'description' => 'DESCRIPTION1',
            'expression' => 'EXPRESSION1'
        ]);
        Achievement::create([
            'name' => 'NAME2',
            'slug' => 'SLUG2',
            'description' => 'DESCRIPTION2',
            'expression' => 'EXPRESSION2'
        ]);
        Achievement::create([
            'name' => 'NAME3',
            'description' => 'DESCRIPTION3',
            'expression' => 'EXPRESSION3'
        ]);

        $response = $this->get('/api/achievements/index', ['Accept' => 'application/json']);
        $response
            ->assertStatus(200)
            ->assertSee(['page' => AchievementCollection::PAGE, 'per-page' => AchievementCollection::PER_PAGE])
            ->assertSee([
                'name' => 'NAME1',
                'slug' => 'SLUG1',
                'description' => 'DESCRIPTION1',
                'expression' => 'EXPRESSION1'
            ]);

        $response = $this->get('/api/achievements/index?page=3&per-page=1', ['Accept' => 'application/json']);
        $response
            ->assertStatus(200)
            ->assertSee(['page' => 3, 'per-page' => 1])
            ->assertSee([
                'name' => 'NAME3',
                'slug' => 'NAME3',
                'description' => 'DESCRIPTION3',
                'expression' => 'EXPRESSION3'
            ]);
    }
}
