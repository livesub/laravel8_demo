<?php
#############################################################################
#
#		파일이름		:		Defalut_htmlController.php
#		파일설명		:		프론트 일반 HTML 모듈 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers\defalut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;

class Defalut_htmlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pg_name, Request $request)
    {
        $page_info = DB::table('menuses')->where('menu_name_en', $pg_name)->first();

        return view('defalut.defalut_page',[
            "menu_name_kr"      => $page_info->menu_name_kr,
            "menu_name_en"      => $page_info->menu_name_en,
            "menu_content"      => $page_info->menu_content,
        ]);
    }
}
