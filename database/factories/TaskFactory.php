<?php


namespace Database\Factories;


use App\Models\Exercise;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{

    protected $model = Task::class;

    public function definition()
    {
        return [
            'title'       => 'Task. #' . $this->faker->bothify('#?#-#?#'),
            'description' => $this->faker->text(100)
        ];
    }
}
