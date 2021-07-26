<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class ExerciseToGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    #[NoReturn]
    public function run(): void
    {
        $exerciseIds = DB::table('exercises')->select('id')->get()->pluck('id');
        $exerciseGroupIds = DB::table('exercise_groups')->select('id')->get()->pluck('id');

        $quantity = ($exerciseIds->count() < $exerciseGroupIds->count()) ? $exerciseIds->count() : $exerciseGroupIds->count();

        for ($i = 0; $i < $quantity; $i++) {
            DB::table('exercises_to_groups')->insert([
                'exercise_id' => $exerciseIds->random(),
                'group_id' => $exerciseGroupIds->random()
            ]);
        }
    }
}
