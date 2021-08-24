<?php
#############################################################################
#
#		파일이름		:		items.php
#		파일설명		:		상품 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    //use HasFactory, Notifiable;
    use HasFactory;

    protected $fillable = [
        'ca_id',
        'item_code',
        'item_name',
        'item_display',
        'item_rank',
        'item_content',
        'item_img',
        'item_ori_img',
    ];

    protected $hidden = [
        'item_img',
        'item_ori_img',
    ];

    protected $casts = [
        'item_img',
        'item_ori_img',
    ];
}
