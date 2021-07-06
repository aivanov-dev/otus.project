<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Achievement;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AchievementsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * @return void
     */
    public function test_if_slug_generation_from_name_is_working_if_omitted()
    {
        Achievement::create([
            'name' => 'NAME3',
            'description' => 'DESCRIPTION3',
            'expression' => 'EXPRESSION3'
        ]);

        $this->assertDatabaseHas(Achievement::class, [
            'name' => 'NAME3',
            'slug' => 'name3',
            'description' => 'DESCRIPTION3',
            'expression' => 'EXPRESSION3'
        ]);

        Achievement::create([
            'name' => 'NAME5',
            'slug' => 'specified-slug',
            'description' => 'DESCRIPTION5',
            'expression' => 'EXPRESSION5'
        ]);

        $this->assertDatabaseHas(Achievement::class, [
            'name' => 'NAME5',
            'slug' => 'specified-slug',
            'description' => 'DESCRIPTION5',
            'expression' => 'EXPRESSION5'
        ]);
    }
}
