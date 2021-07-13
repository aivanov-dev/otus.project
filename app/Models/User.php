<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use HasFactory,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    /**
     * @return HasMany
     */
    public function taskResults(): HasMany
    {
        return $this->hasMany(TaskResult::class);
    }

    /**
     * @return BelongsToMany
     */
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class)->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }
}
