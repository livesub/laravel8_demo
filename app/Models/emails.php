<?php
#############################################################################
#
#		파일이름		:		emails.php
#		파일설명		:		회원 이메일 내용 저장 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emails extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_subject',
        'email_content',
        'email_file1',
        'email_ori_file1',
        'email_file2',
        'email_ori_file2',
    ];

    protected $hidden = [
        'email_file1',
        'email_ori_file1',
        'email_file2',
        'email_ori_file2',
    ];

    protected $casts = [
    ];
}
