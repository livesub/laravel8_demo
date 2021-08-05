<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    //use HasFactory, Notifiable;
    use HasFactory;

    protected $fillable = [
        'ca_id',
        'item_code',
        'item_name',
        'item_display',
        'item_rank',
        'item_content',
        'item_img',
        'item_ori_img',
    ];

    protected $hidden = [
        'item_img',
        'item_ori_img',
    ];

    protected $casts = [
        'item_img',
        'item_ori_img',
    ];
}
