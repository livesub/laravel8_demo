<?php

namespace App\Http\Controllers\adm\item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\items;    //상품 모델 정의


class AdmitemContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));


        return view('adm.item.itemlist',[
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id     = $request->input('ca_id');

        //1단계 기본 가져옴
        $one_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->whereRaw('length(ca_id) = 2')->orderby('ca_id', 'ASC')->get();   //정보 읽기

        return view('adm.item.itemcreate',[
            'item_code'         => "item_".time(),
            'ca_id'             => $ca_id,
            'one_step_infos'    => $one_step_infos,
        ]);
    }

    public function ajax_select(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id     = $request->input('ca_id');
        $length     = $request->input('length');

        $qry = "";
        if($ca_id != ""){
            if($length == '2'){
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '4' ";
            }elseif($_POST['length']=='4'){
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '6'  ";
            }elseif($_POST['length']=='6'){
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '8'  ";
            }elseif($_POST['length']=='8'){
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '10'  ";
            }
        }

        $cate_infos = DB::select($qry);
        $num_rows = count($cate_infos);

        $output = "";
        if($num_rows > 0){
            if($length == '2'){
                $output = '<select name="ca_id" size="15" id="caa_id2"class="cid"  >';
            }elseif($length == '4'){
                $output = '<select name="ca_id" size="15" id="caa_id3"class="cid" >';
            }elseif($length == '6'){
                $output = '<select name="ca_id" size="15" id="caa_id4"class="cid" >';
            }elseif($length == '8'){
                $output = '<select name="ca_id" size="15" id="caa_id5"class="cid" >';
            }

            foreach($cate_infos as $cate_info){
                $output .= '<option value="'.$cate_info->ca_id.'">'.$cate_info->ca_name_kr.'</option>';
            }
            $output .= '</select>';
        }

        //exit(json_encode(array('success' => '1', 'data' => $output,'site'=>$_POST['ca_id'])));
        return response()->json(['success' => '1','data' => $output, 'site' => $ca_id], 200, [], JSON_PRETTY_PRINT);
        exit;
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
