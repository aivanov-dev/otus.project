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
        $user = User::query()->inRandomOrder()->limit(1)->first();
        $query = Task::query();
        $userTasks = $user->taskResults->map(fn(TaskResult $result) => $result->task->getKey());
        if($userTasks->isNotEmpty()){
            $query->whereNotIn('id', $userTasks);
        }
        $task = $query->inRandomOrder()->limit(1)->first();
        if(!$task){
            return $this->definition();
        }
        return [
            'user_id' =>$user->getKey(),
            'task_id' => $task->getKey(),
            'exercise_group_id' => $task->exercise->groups->random(),
            'assessment' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween('-2 years')
        ];
    }
}
