<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopcarts extends Model
{
    use HasFactory;

    protected $fillable = [
        'od_id',
        'user_id',
        'item_code',
        'item_name',
        'item_sc_type',
        'item_sc_method',
        'item_sc_price',
        'item_sc_minimum',
        'item_sc_qty',
        'sct_status',
        'sct_history',
        'sct_price',
        'sct_point',
        'sct_point_use',
        'sct_stock_use',
        'sct_option',
        'sct_qty',
        'sio_id',
        'sio_type',
        'sio_price',
        'sct_ip',
        'sct_send_cost',
        'sct_direct',
        'sct_select',
        'sct_select_time',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}






