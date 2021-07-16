<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskResult extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['task_id', 'user_id', 'assessment', 'exercise_group_id'];

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
