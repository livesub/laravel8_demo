<?php
#############################################################################
#
#		파일이름		:		shop_uniqids.php
#		파일설명		:		장바구니 유일키 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 20일
#		최종수정일		:		2021년 09월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shop_uniqids extends Model
{
    use HasFactory;

    protected $fillable = [
        'uq_id',
        'uq_ip',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
