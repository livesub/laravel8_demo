<?php
#############################################################################
#
#		파일이름		:		CategoryController.php
#		파일설명		:		shop 카테고리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 24일
#		최종수정일		:		2021년 09월 24일
#
###########################################################################-->

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cate_list()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $one_step_infos = DB::table('shopcategorys')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_rank', 'DESC')->get();   //정보 읽기

        $customutils = new CustomUtils();

        return view('menu.shopcatelist',[
            'one_step_infos'    => $one_step_infos,
            'customutils'       => $customutils,
        ]);
    }
}
