<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class email_sends extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id',
        'email_user_id',
        'email_send_chk',
        'email_receive_chk',
        'email_receive_token',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
