<?php

namespace App\Models;

use App\Traits\HasCountMetric;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->task()->first()->exercise();
    }

    /**
     * @return BelongsTo
     */
    public function exerciseGroups(): BelongsTo
    {
        return $this->belongsTo(ExerciseGroup::class);
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
