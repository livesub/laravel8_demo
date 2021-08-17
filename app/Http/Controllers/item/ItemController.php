<?php

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
        $writeList   = 16;  //페이지당 글수
        $pageNumList = 16; //블럭당 페이지수

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
