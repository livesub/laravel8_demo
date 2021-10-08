<?php
#############################################################################
#
#		파일이름		:		membervisits.php
#		파일설명		:		회원 로그인 통계 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membervisits extends Model
{
    use HasFactory;

    protected $fillable = [
        'mv_id',
        'user_id',
        'mv_ip',
        'mv_referer',
        'mv_agent',
        'mv_browser',
        'mv_os',
        'mv_device',
        'mv_city',
        'mv_country',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
