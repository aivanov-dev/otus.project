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
            'name' => 'First task!',
            'description' => 'First task done. Keep going!',
            'expression' => "taskResult.ofTaskAndExerciseAndUser(taskResult.task.exercise.id, taskResult.task_id, taskResult.user_id).isNotEmpty()"
        ]);

        Achievement::create([
            'name' => 'Excellent!',
            'description' => 'All tasks are passed with highest grade!',
            'expression' => "taskResult.exercise.taskResults.countWithCondition('assessment', 10) / taskResult.exercise.taskResults.count() == 1"
        ]);

        Achievement::create([
            'name' => 'Almost excellent!',
            'description' => 'You passed 90% of tasks with grade equal or greater than 9. Keep going!',
            'expression' => "( taskResult.exercise.taskResults.countWithCondition('assessment', 9, '>=') / taskResult.exercise.taskResults.count() ) >= 0.9"
        ]);
    }
}
