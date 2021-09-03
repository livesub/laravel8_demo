<?php
#############################################################################
#
#		파일이름		:		PopupController.php
#		파일설명		:		프론트 팝업 보이기
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 03일
#		최종수정일		:		2021년 09월 03일
#
###########################################################################-->

namespace App\Http\Controllers\popup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use App\Models\popups;    //팝업 모델 정의

class PopupController extends Controller
{
    public function popup_for()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $now_date = date("Y-m-d H:i:s",time());

        $pop_lists = DB::select("select * from popups where '{$now_date}' between pop_start_time and pop_end_time and pop_display = 'Y' ");

        return view('popup.poplist',[
            'pop_lists'          => $pop_lists,
        ]);
    }
}
