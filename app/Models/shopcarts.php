<?php
#############################################################################
#
#		파일이름		:		shopcarts.php
#		파일설명		:		장바구니 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 20일
#		최종수정일		:		2021년 09월 20일
#
###########################################################################-->

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






