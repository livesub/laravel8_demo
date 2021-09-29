<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shop_uniqids extends Model
{
    use HasFactory;

    protected $fillable = [
        'uq_id',
        'uq_ip',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
