<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'expression'
    ];

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($model) {
            $model->attributes['slug'] = Str::slug($model->attributes['name'], '-');
        });
    }
}
