<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorys extends Model
{
    //use HasFactory, Notifiable;
    use HasFactory;

    protected $fillable = [
        'ca_id',
        'ca_name_kr',
        'ca_name_en',
        'ca_display',
        'ca_rank',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
