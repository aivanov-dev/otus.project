<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskResultStatistics;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskResultStatisticsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaskResultStatistics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'task_id' => $this->faker->unique()->randomElement(Task::pluck('id', 'id')->toArray()),
            'assessment' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween('-1 years')
        ];
    }
}
