<?php
#############################################################################
#
#		파일이름		:	    shopcoupons.php
#		파일설명		:		쇼핑몰 쿠폰 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 07일
#		최종수정일		:		2021년 10월 07일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopcoupons extends Model
{
    use HasFactory;

    protected $fillable = [
        'cp_id',
        'cp_subject',
        'cp_method',
        'cp_target',
        'user_id',
        'cz_id',
        'cp_start',
        'cp_end',
        'cp_price',
        'cp_type',
        'cp_minimum',
        'cp_maximum',
        'od_id',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
