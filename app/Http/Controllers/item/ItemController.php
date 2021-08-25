<?php
#############################################################################
#
#		파일이름		:		ItemController.php
#		파일설명		:		프론트 상품 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers\item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        $type = 'items';
        $cate = "";

        $search_sql = "";
        if($keymethod != "" && $keyword != ""){
            $search_sql = " AND a.{$keymethod} LIKE '%{$keyword}%' ";
        }

        $page_control = CustomUtils::page_function('items',$pageNum,$writeList,$pageNumList,$type,$tb_name,$cate,$keymethod,$keyword);


        if($ca_id == ""){
            $cate_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 2')->orderby('ca_rank', 'DESC')->get();
            $item_infos = DB::select("select a.*, b.ca_id from items a, categorys b where 1 AND item_display = 'Y' AND a.ca_id = b.ca_id  {$search_sql} order by a.item_rank DESC limit {$page_control['startNum']}, {$writeList} ");

        }else{
            $down_cate = DB::table('categorys')->where('ca_id','like',$ca_id.'%')->count();   //하위 카테고리 갯수
            if($down_cate != 1){
                $length = $length + 2;
                $cate_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->where('ca_id','<>',$ca_id )->whereRaw('length(ca_id) = '.$length)->whereRaw("ca_id like '{$ca_id}%'")->orderby('ca_rank', 'DESC')->get();
            }else{  //하위 카테고리가 없을때 처리
                $cate_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->where('ca_id','=',$ca_id )->whereRaw('length(ca_id) = '.$length)->whereRaw("ca_id like '{$ca_id}%'")->orderby('ca_rank', 'DESC')->get();
            }

            $item_infos = DB::select("select a.*, b.ca_id from items a, categorys b where 1 AND item_display = 'Y' AND a.ca_id = b.ca_id AND a.ca_id like '{$ca_id}%' {$search_sql} order by a.item_rank DESC limit {$page_control['startNum']}, {$writeList} ");
        }

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];


        return view('item.item_page',[
            'ca_id'         => $ca_id,
            'cate_infos'    => $cate_infos,
            'item_infos'    => $item_infos,
            'pageList'      => $pageList,
            'keymethod'     => $keymethod,
            'keyword'       => $keyword,
            'totalCount'    => $page_control['totalCount'],
            'pageNum'       => $page_control['pageNum'],
            'pageList'      => $pageList,
        ]);
    }

}
