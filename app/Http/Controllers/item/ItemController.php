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

        if($ca_id == ""){
            $cate_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 2')->orderby('ca_rank', 'DESC')->get();

            $item_infos = DB::table('items')->select('ca_id', 'item_code', 'item_name', 'item_img')->where('item_display','Y')->orderby('item_rank', 'DESC')->get();
        }else{
            $length = $length + 2;
            $cate_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->where('ca_id','<>',$ca_id )->whereRaw('length(ca_id) = '.$length)->whereRaw("ca_id like '{$ca_id}%'")->orderby('ca_rank', 'DESC')->get();

            $item_infos = DB::table('items')->select('ca_id', 'item_code', 'item_name', 'item_img')->where('item_display','Y')->whereRaw("ca_id like '{$ca_id}%'")->orderby('item_rank', 'DESC')->get();
        }




        return view('item.item_page',[
            'cate_infos'    => $cate_infos,
            'item_infos'    => $item_infos,
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
