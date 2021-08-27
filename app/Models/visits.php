<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visits extends Model
{
    use HasFactory;

    protected $fillable = [
        'vi_id',
        'vi_ip',
        'vi_referer',
        'vi_agent',
        'vi_browser',
        'vi_os',
        'vi_device',
        'vi_city',
        'vi_country',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
