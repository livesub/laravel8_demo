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
        'bm_type',
        'bm_skin',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

}
