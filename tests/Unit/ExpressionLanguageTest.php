<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Exercise;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionLanguageTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     *
     * @return void
     */
    #[NoReturn]
    public function test_expression_language(): void
    {
        $expressionLanguage = new ExpressionLanguage();

        $user = User::create([
            'name' => 'TestUser1'
        ]);
        $exercise = Exercise::create([
            'name' => 'TestExercise1'
        ]);

        $task = Task::create([
            'exercise_id' => $exercise->id,
            'title' => 'TestTask1',
            'description' => 'TestTaskDescription1'
        ]);

        $task->results()->createMany([
            [
                'task_id' => $task->id,
                'user_id' => $user->id,
                'assessment' => 10
            ],
            [
                'task_id' => $task->id,
                'user_id' => $user->id,
                'assessment' => 10
            ],
            [
                'task_id' => $task->id,
                'user_id' => $user->id,
                'assessment' => 9
            ],
            [
                'task_id' => $task->id,
                'user_id' => $user->id,
                'assessment' => 9
            ],
            [
                'task_id' => $task->id,
                'user_id' => $user->id,
                'assessment' => 8
            ]
        ]);

        //countWithCondition is an custom method for collection added via macro
        //accepts 3 arguments: compared key, value, and operator (optional, default is '==')
        $expressionAll10 = "exercise.taskResults.countWithCondition('assessment', 10)";
        $this->assertEquals(2, $expressionLanguage->evaluate($expressionAll10, ['exercise' => $exercise]));

        $expression9over90 = "( exercise.taskResults.countWithCondition('assessment', 9, '>=') / exercise.taskResults.count() ) >= 0.9";
        $this->assertFalse($expressionLanguage->evaluate($expression9over90, ['exercise' => $exercise]));
    }
}
