<?php

namespace Tests\Feature\Achievements;

use Tests\TestCase;
use App\Models\Achievement;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteRouteTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     *
     * @return void
     */
    public function test_if_delete_route_is_ok()
    {
        $achievement = Achievement::create([
            'name' => 'NAME!',
            'expression' => 'EXPRESSION!'
        ]);

        $response = $this->delete("/api/achievements/84516");
        $response->assertStatus(404);

        $response = $this->delete("/api/achievements/{$achievement->id}");
        $response
            ->assertStatus(204);

        $this->assertDatabaseMissing(Achievement::class, [
            'name' => 'NAME!',
            'expression' => 'EXPRESSION!'
        ]);
    }
}
