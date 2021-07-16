<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;

class ExerciseGroup extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = ['name', 'parent_id'];

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'exercises_to_groups', 'group_id', 'exercise_id');
    }
}
