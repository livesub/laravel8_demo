<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class board_datas_table extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'bm_tb_name',
        'bdt_grp',
        'bdt_sort',
        'bdt_depth',
        'bdt_ip',
        'bdt_chk_secret',
        'bdt_uid',
        'bdt_uname',
        'bdt_upw',
        'bdt_subject',
        'bdt_content',
        'bdt_category',
        'bdt_ori_file_name1',
        'bdt_file1',
        'bdt_ori_file_name2',
        'bdt_file2',
        'bdt_ori_file_name3',
        'bdt_file3',
        'bdt_ori_file_name4',
        'bdt_file4',
        'bdt_ori_file_name5',
        'bdt_file5',
    ];

    protected $hidden = [
        'bdt_upw',
        'bdt_ori_file_name1',
        'bdt_file1',
        'bdt_ori_file_name2',
        'bdt_file2',
        'bdt_ori_file_name3',
        'bdt_file3',
        'bdt_ori_file_name4',
        'bdt_file4',
        'bdt_ori_file_name5',
        'bdt_file5',
    ];

    protected $casts = [
        'bdt_ori_file_name1',
        'bdt_file1',
        'bdt_ori_file_name2',
        'bdt_file2',
        'bdt_ori_file_name3',
        'bdt_file3',
        'bdt_ori_file_name4',
        'bdt_file4',
        'bdt_ori_file_name5',
        'bdt_file5',
    ];
}
