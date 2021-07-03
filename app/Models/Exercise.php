<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Exercise extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name'];

    /**
     * @var bool
     */
    public $timestamps = false;

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @return HasManyThrough
     */
    public function taskResults(): HasManyThrough
    {
        return $this->hasManyThrough(TaskResult::class, Task::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(ExerciseGroup::class, 'exercises_to_groups', 'exercise_id', 'group_id');
    }
}
