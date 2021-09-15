<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopitemoptions extends Model
{
    //use HasFactory, Notifiable;
    use HasFactory;

    protected $fillable = [
        'sio_id',
        'sio_type',
        'item_code',
        'sio_price',
        'sio_stock_qty',
        'sio_noti_qty',
        'sio_use',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
