<?php

namespace Database\Seeders;

use App\Models\ExerciseGroup;
use App\Models\Task;
use App\Models\TaskResult;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::pluck('id')->all();
        $taskIds = Task::pluck('id')->all();
        $exerciseGroupsIds = ExerciseGroup::pluck('id')->all();
        TaskResult::factory(20)
            ->state(fn() => [
                'user_id' => array_rand($userIds, 1),
                'task_id' => array_rand($taskIds, 1),
                'exercise_group_id' => array_rand($exerciseGroupsIds, 1),
            ])
            ->create();
    }
}
