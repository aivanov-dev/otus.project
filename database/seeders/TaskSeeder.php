<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Influence;
use App\Models\Skill;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = Skill::all();

        $exercises = Exercise::all(['id']);
        Task::factory(300)
            ->state(fn() => [
                'exercise_id' => $exercises->random()->id
            ])
            ->create()
            ->each(static function (Task $task) use ($skills) {
                $limit = Collection::make([1, 2, 4, 5])->random();
                $values =  Collection::times(100, fn() => 1)
                    ->split($limit)->map(fn($i) => $i->sum());
                $skills
                    ->random($limit)
                    ->each(fn(Skill $skill) =>  Influence::create([
                        'value'    => $values->shift(),
                        'skill_id' => $skill->getKey(),
                        'task_id'  => $task->getKey()
                    ]));
            });

    }
}
