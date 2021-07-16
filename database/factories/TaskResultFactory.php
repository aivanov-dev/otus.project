<?php

namespace Database\Factories;

use App\Models\TaskResult;
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
            'assessment' => $this->faker->numberBetween(1, 10)
        ];
    }
}
