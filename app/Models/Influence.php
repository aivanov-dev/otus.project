<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influence extends Model
{
    use HasFactory;

    protected $fillable = ['skill_id', 'task_id', 'value'];
    public $timestamps = false;

    public function skill(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
