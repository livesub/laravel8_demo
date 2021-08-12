<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menus extends Model
{
    //use HasFactory, Notifiable;
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'menu_name_kr',
        'menu_name_en',
        'menu_display',
        'menu_rank',
        'menu_page_type',
        'menu_content',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
