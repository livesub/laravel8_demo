<?php
#############################################################################
#
#		파일이름		:		baesongjis.php
#		파일설명		:		배송지 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 20일
#		최종수정일		:		2021년 09월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class baesongjis extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'user_id',
        'ad_subject',
        'ad_default',
        'ad_name',
        'ad_tel',
        'ad_hp',
        'ad_zip1',
        'ad_addr1',
        'ad_addr2',
        'ad_addr3',
        'ad_jibeon',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
