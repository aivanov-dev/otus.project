<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exerciseIds = DB::table('exercises')->select('id')->get()->pluck('id');

        Task::factory()->count(10)->create([
            'exercise_id' => $exerciseIds->random(),
        ]);
    }
}
