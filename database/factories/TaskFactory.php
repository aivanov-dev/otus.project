<?php

namespace Database\Factories;

use App\Models\Task;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    #[ArrayShape(['title' => "string", 'description' => "string"])]
    public function definition(): array
    {
        return [
            'title'       => 'Task. #' . $this->faker->bothify('#?#-#?#'),
            'description' => $this->faker->text(100)
        ];
    }
}
