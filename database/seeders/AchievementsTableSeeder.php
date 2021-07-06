<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Achievement::create([
            'name' => 'Excellent!',
            'description' => 'All tasks are passed with highest grade!',
            'expression' => 'exercise.taskResults.countWithCondition("assessment", 10)'
        ]);

        Achievement::create([
            'name' => 'Almost excellent!',
            'description' => 'You passed 90% of tasks with grade equal or greater than 9. Keep going!',
            'expression' => '( exercise.taskResults.countWithCondition("assessment", 9, ">=") / exercise.taskResults.count() ) >= 0.9'
        ]);
    }
}
