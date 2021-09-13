<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopitems extends Model
{
    //use HasFactory, Notifiable;
    use HasFactory;

    protected $fillable = [
        'sca_id',
        'sitem_code',
        'sitem_name',
        'sitem_display',
        'sitem_rank',
        'sitem_content',
        'sitem_img',
        'sitem_ori_img',
    ];

    protected $hidden = [
        'sitem_img',
        'sitem_ori_img',
    ];

    protected $casts = [
        'sitem_img',
        'sitem_ori_img',
    ];
}
