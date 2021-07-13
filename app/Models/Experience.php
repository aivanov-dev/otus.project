<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['skill_id', 'user_id', 'experience'];
}
