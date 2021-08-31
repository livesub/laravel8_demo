<?php
#############################################################################
#
#		파일이름		:		shopcategorys.php
#		파일설명		:		쇼핑몰 카테고리 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 31일
#		최종수정일		:		2021년 08월 31일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopcategorys extends Model
{
    //use HasFactory, Notifiable;
    use HasFactory;

    protected $fillable = [
        'sca_id',
        'sca_name_kr',
        'sca_name_en',
        'sca_display',
        'sca_rank',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
