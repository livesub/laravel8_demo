<?php
#############################################################################
#
#		파일이름		:		popups.php
#		파일설명		:		팝업 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class popups extends Model
{
    use HasFactory;

    protected $fillable = [
        'pop_disable_hours',
        'pop_start_time',
        'pop_end_time',
        'pop_left',
        'pop_top',
        'pop_width',
        'pop_height',
        'pop_subject',
        'pop_content',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}