<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class popups extends Model
{
    use HasFactory;

    protected $fillable = [
        'pop_disable_hours',
        'pop_start_time',
        'pop_end_time',
        'pop_left',
        'pop_top',
        'pop_width',
        'pop_height',
        'pop_subject',
        'pop_content',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}