<?php

namespace Tests\Unit;

use App\Models\TaskResult;
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
                'assessment' => 9.5
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

        $taskResult = TaskResult::first();

        // countWithCondition is an custom method for collection added via macro
        // accepts 3 arguments: compared key, value, and operator (optional, default is '==')
        $expressionAll10 = "taskResult.exercise.taskResults.countWithCondition('assessment', 10)";
        $this->assertEquals(2, $expressionLanguage->evaluate($expressionAll10, ['taskResult' => $taskResult]));

        $expressionAll10 = "taskResult.exercise.taskResults.countWithCondition('assessment', 9.5)";
        $this->assertEquals(1, $expressionLanguage->evaluate($expressionAll10, ['taskResult' => $taskResult]));

        //in app writes expression in such a way they return only true of false
        //все ли задания в занятии выполнены на 10 баллов?
        //так как в контролере будет только $taskResult, то начинаю с $taskResult
        $expressionAll10 = "taskResult.ofTaskAndExerciseAndUser(taskResult.task.exercise.id, taskResult.task_id, taskResult.user_id).countWithCondition('assessment', 10)
        / taskResult.ofTaskAndExerciseAndUser(taskResult.task.exercise.id, taskResult.task_id, taskResult.user_id).count() == 1";

        $this->assertFalse($expressionLanguage->evaluate($expressionAll10, ['taskResult' => $taskResult]));

        //доля оценок выше 9 больше 90%?
        $expression9over90 = "taskResult.ofTaskAndExerciseAndUser(taskResult.task.exercise.id, taskResult.task_id, taskResult.user_id).countWithCondition('assessment', 9, '>=')
         / taskResult.ofTaskAndExerciseAndUser(taskResult.task.exercise.id, taskResult.task_id, taskResult.user_id).count() >= 0.9";
        $this->assertFalse($expressionLanguage->evaluate($expression9over90, ['taskResult' => $taskResult]));

        //первое занятие студента в данном задании и занятии выполнено на любою оценку
        $expressionFirst = "taskResult.ofTaskAndExerciseAndUser(taskResult.task.exercise.id, taskResult.task_id, taskResult.user_id).isNotEmpty()";

        $this->assertTrue($expressionLanguage->evaluate($expressionFirst, ['taskResult' => $taskResult]));
    }
}
