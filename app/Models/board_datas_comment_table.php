<?php
#############################################################################
#
#		파일이름		:		board_datas_comment_table.php
#		파일설명		:		게시판 덧글 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class board_datas_comment_table extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'bm_tb_name',
        'bdt_id',
        'bdct_uid',
        'bdct_uname',
        'bdct_memo',
        'bdct_grp',
        'bdct_sort',
        'bdct_depth',
        'bdct_ip',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}
