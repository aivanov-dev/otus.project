<?php

namespace Database\Seeders;

use App\Models\TaskResult;
use Illuminate\Database\Seeder;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Facades\DB;

class TaskResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    #[NoReturn]
    public function run(): void
    {
        $userIds = DB::table('users')->select('id')->get()->pluck('id');
        $taskIds = DB::table('tasks')->select('id')->get()->pluck('id');
        $exerciseGroupsIds = DB::table('exercise_groups')->select('id')->get()->pluck('id');

        TaskResult::factory()->count(20)->create([
            'task_id' => $taskIds->random(),
            'user_id' => $userIds->random(),
            'exercise_group_id' => $exerciseGroupsIds->random(),
        ]);
    }
}
