<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['code', 'name'];

    /**
     * @var bool
     */
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        self::deleting();
    }

    /**
     * @return HasMany
     */
    public function influences(): HasMany
    {
        return $this->hasMany(Influence::class);
    }

    /**
     * @return HasMany
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'influences');
    }
}
