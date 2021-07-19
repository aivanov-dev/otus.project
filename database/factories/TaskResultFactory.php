<?php

namespace Database\Factories;

use App\Models\ExerciseGroup;
use App\Models\Task;
use App\Models\TaskResult;
use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaskResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition(): array
    {
        return [
            'user_id' => User::all()->random(),
            'task_id' => Task::all()->random(),
            'exercise_group_id' => ExerciseGroup::all()->random(),
            'assessment' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween('-2 years')
        ];
    }
}
