<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emails extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_subject',
        'email_content',
        'email_file1',
        'email_ori_file1',
        'email_file2',
        'email_ori_file2',
    ];

    protected $hidden = [
        'email_file1',
        'email_ori_file1',
        'email_file2',
        'email_ori_file2',
    ];

    protected $casts = [
    ];
}
