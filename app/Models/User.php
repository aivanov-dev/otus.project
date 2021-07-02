<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name'
    ];

    public function taskResults(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskResult::class);
    }
}
