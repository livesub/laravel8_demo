<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membervisits extends Model
{
    use HasFactory;

    protected $fillable = [
        'mv_id',
        'user_id',
        'mv_ip',
        'mv_referer',
        'mv_agent',
        'mv_browser',
        'mv_os',
        'mv_device',
        'mv_city',
        'mv_country',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
