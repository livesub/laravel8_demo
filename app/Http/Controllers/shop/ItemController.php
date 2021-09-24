<?php
#############################################################################
#
#		파일이름		:		ItemController.php
#		파일설명		:		카테고리별 상품 리스트 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 24일
#		최종수정일		:		2021년 09월 24일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id          = $request->input('ca_id');
        $length         = strlen($ca_id);

        //pgae 관련
        $pageNum     = $request->input('page');
        $writeList   = 15;  //페이지당 글수
        $pageNumList = 15; //블럭당 페이지수

        //검색 처리
        $keymethod      = $request->input('keymethod');
        $keyword        = $request->input('keyword');
        if($keymethod == "") $keymethod = "item_name";

        $tb_name = "items";
        $type = 'shopitems';
        $cate = "";

        $search_sql = "";
        if($keymethod != "" && $keyword != ""){
            $search_sql = " AND a.{$keymethod} LIKE '%{$keyword}%' ";
        }

        $page_control = CustomUtils::page_function('shopitems',$pageNum,$writeList,$pageNumList,$type,$tb_name,$ca_id,$keymethod,$keyword);

        if($ca_id == ""){
            $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_rank', 'DESC')->get();
            $item_infos = DB::select("select a.*, b.sca_id from shopitems a, shopcategorys b where 1 AND item_display = 'Y' AND a.sca_id = b.sca_id  {$search_sql} order by a.item_rank DESC limit {$page_control['startNum']}, {$writeList} ");

        }else{
            $down_cate = DB::table('shopcategorys')->where('sca_id','like',$ca_id.'%')->count();   //하위 카테고리 갯수
            if($down_cate != 1){
                $length = $length + 2;
                $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->where('sca_id','<>',$ca_id )->whereRaw('length(sca_id) = '.$length)->whereRaw("sca_id like '{$ca_id}%'")->orderby('sca_rank', 'DESC')->get();
            }else{  //하위 카테고리가 없을때 처리
                $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->where('sca_id','=',$ca_id )->whereRaw('length(sca_id) = '.$length)->whereRaw("sca_id like '{$ca_id}%'")->orderby('sca_rank', 'DESC')->get();
            }

            $item_infos = DB::select("select a.*, b.sca_id from shopitems a, shopcategorys b where 1 AND item_display = 'Y' AND a.sca_id = b.sca_id AND a.sca_id like '{$ca_id}%' {$search_sql} order by a.item_rank DESC limit {$page_control['startNum']}, {$writeList} ");
        }

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        $CustomUtils = new CustomUtils();
        return view('shop.item_page',[
            'ca_id'         => $ca_id,
            'cate_infos'    => $cate_infos,
            'item_infos'    => $item_infos,
            'pageList'      => $pageList,
            'keymethod'     => $keymethod,
            'keyword'       => $keyword,
            'totalCount'    => $page_control['totalCount'],
            'pageNum'       => $page_control['pageNum'],
            'pageList'      => $pageList,
            'CustomUtils'   => $CustomUtils,
        ]);
    }

    public function sitemdetail(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code          = $request->input('item_code');
dd($item_code);
//$item_info = DB::table('shopitems')->where('item_code', $item_code)->first();   //상품 정보
        return view('shop.item_detail',[
        ]);
    }
}
