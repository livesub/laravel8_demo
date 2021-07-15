<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class boardmanager extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'bm_tb_name',
        'bm_tb_subject',
        'bm_file_num',
    ];

    protected $hidden = [
/*
        'password',
        'remember_token',
        'user_confirm_code',
        'user_level',
        'user_phone',
        'user_type'
*/
    ];

    protected $casts = [
/*
        'email_verified_at' => 'datetime',
        'user_activated' => 'boolean'
*/
    ];

}
