<?php
#############################################################################
#
#		파일이름		:		email_sends.php
#		파일설명		:		회원 이메일 발송 내역 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

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
