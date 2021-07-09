<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\ExerciseGroup;
use Illuminate\Database\Seeder;

class ExerciseGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TODO: remove
        ExerciseGroup::factory(5)
            ->has(Exercise::factory(5))
            ->create()
            ->each(fn(ExerciseGroup $group) => ExerciseGroup::factory(rand(2, 4))
                ->create(['parent_id' => $group->getKey()])
                ->each(fn(ExerciseGroup $subGroup) => ExerciseGroup::factory(rand(2, 6))
                    ->has(Exercise::factory(3))
                    ->create(['parent_id' => $subGroup->getKey()]))
            );
    }
}
