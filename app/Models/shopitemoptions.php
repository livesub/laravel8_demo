<?php
#############################################################################
#
#		파일이름		:		shopitemoptions.php
#		파일설명		:		상품 옵션 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 20일
#		최종수정일		:		2021년 09월 20일
#
###########################################################################-->

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
