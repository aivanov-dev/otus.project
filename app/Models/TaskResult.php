<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskResult extends Model
{
    use HasFactory;

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
    public function exerciseGroups(): BelongsTo
    {
        return $this->belongsTo(ExerciseGroup::class);
    }
}
