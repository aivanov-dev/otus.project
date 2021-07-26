<?php

namespace App\Models;

use App\Traits\HasCountMetric;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Collection;

class TaskResult extends Model
{
    use HasFactory, HasCountMetric;

    /**
     * @var string[]
     */
    protected $fillable = ['task_id', 'user_id', 'exercise_group_id', 'assessment'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @return BelongsTo
     */
    public function exercise(): BelongsTo
    {
        return $this->task->exercise();
    }

    /**
     * @param $exercideId
     * @param $userId
     *
     * @return Collection
     */
    public function allOfExerciseAndUser($exercideId, $userId): Collection
    {
        return self::query()
            ->select('task_results.*')
            ->leftJoin('tasks', 'tasks.id', '=', 'task_results.task_id')
            ->leftJoin('exercises', 'exercises.id', '=', 'tasks.exercise_id')
            ->where('exercise_id', $exercideId)
            ->where('user_id', $userId)
            ->get()
            ;
    }

    /**
     * @param $exercideId
     * @param $taskId
     * @param $userId
     *
     * @return Collection
     */
    public function ofTaskAndExerciseAndUser($exercideId, $taskId, $userId): Collection
    {
        return self::query()
            ->select('task_results.*')
            ->leftJoin('tasks', 'tasks.id', '=', 'task_results.task_id')
            ->leftJoin('exercises', 'exercises.id', '=', 'tasks.exercise_id')
            ->where('exercise_id', $exercideId)
            ->where('task_id', $taskId)
            ->where('user_id', $userId)
            ->get()
        ;
    }

    /**
     * @return BelongsTo
     */
    public function exerciseGroups(): BelongsTo
    {
        return $this->belongsTo(ExerciseGroup::class);
    }

    public function skill(): HasOneThrough
    {
        return $this->task->hasOneThrough(
            Skill::class,
            Influence::class,
            'task_id',
            'id',
            'id',
            'skill_id'
        );
    }

    public function getCountMetricLabels(): array
    {
        return [
            'id',
            'user_id',
            'task_id',
            'task_title',
            'assessment',
        ];
    }

    public function getCountMetricLabelValues(): array
    {
        return [
            $this->getKey(),
            $this->user->getKey(),
            $this->task->getKey(),
            $this->task->title,
            $this->assessment,

        ];
    }
}
