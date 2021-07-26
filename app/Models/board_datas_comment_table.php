<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class board_datas_comment_table extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'bm_tb_name',
        'bdt_id',
        'bdct_uid',
        'bdct_uname',
        'bdct_memo',
        'bdct_grp',
        'bdct_sort',
        'bdct_depth',
        'bdct_ip',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}
