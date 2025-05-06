<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'title',
        'description',
        'questions',
        'valid_until'
    ];

    protected $casts = [
        'questions' => 'array',
        'valid_until' => 'datetime'
    ];
}
