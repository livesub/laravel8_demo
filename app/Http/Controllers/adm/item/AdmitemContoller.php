<?php

namespace App\Http\Controllers\adm\item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\items;    //상품 모델 정의
use Validator;  //체크

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

        //1단계 가져옴
        $one_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 2')->orderby('ca_id', 'ASC')->get();

        //2단계 가져옴
        $two_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 4')->orderby('ca_id', 'ASC')->get();

        //3단계 가져옴
        $three_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 6')->orderby('ca_id', 'ASC')->get();

        //4단계 가져옴
        $four_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 8')->orderby('ca_id', 'ASC')->get();

        //5단계 가져옴
        $five_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 10')->orderby('ca_id', 'ASC')->get();

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $item_directory = "item/editor";
        setcookie('directory', $item_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        //첨부 파일 저장소
        $target_path = "data/item";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        return view('adm.item.itemcreate',[
            'item_code'         => "item_".time(),
            'ca_id'             => $ca_id,
            'one_step_infos'    => $one_step_infos,
            'two_step_infos'    => $two_step_infos,
            'three_step_infos'  => $three_step_infos,
            'four_step_infos'   => $four_step_infos,
            'five_step_infos'   => $five_step_infos,
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
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '4' and ca_display = 'Y' ";
            }elseif($length == '4'){
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '6' and ca_display = 'Y' ";
            }elseif($length == '6'){
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '8' and ca_display = 'Y' ";
            }elseif($length == '8'){
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '10' and ca_display = 'Y' ";
            }elseif($length == '10'){
                $qry = "SELECT ca_id, ca_name_kr, ca_name_en FROM categorys WHERE ca_id like '{$ca_id}%' and ca_id != '{$ca_id}' and length(ca_id) = '12' and ca_display = 'Y' ";
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
            }elseif($length == '10'){
                $output = '<select name="ca_id" size="15" id="caa_id6"class="cid" >';
            }

            foreach($cate_infos as $cate_info){
                $output .= '<option value="'.$cate_info->ca_id.'">'.$cate_info->ca_name_kr.'</option>';
            }
            $output .= '</select>';
        }

        if($cate_infos == null) $ca_name_kr = "";
        else $ca_name_kr = $cate_info->ca_name_kr;

        return response()->json(['success' => '1','data' => $output, 'ca_id' => $ca_id], 200, [], JSON_PRETTY_PRINT);
        exit;
    }

    public function createsave(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        if(!isset($_COOKIE['directory'])){  //쿠키 값이 사라진 후에 저장 되지 않게
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $ca_id              = $request->input('ca_id');
        $length             = $request->input('length');
        $last_choice_ca_id  = $request->input('last_choice_ca_id');
        $item_code          = $request->input('item_code');
        $item_name          = addslashes($request->input('item_name'));
        $item_display       = $request->input('item_display');
        $item_rank          = $request->input('item_rank');
        $item_content       = $request->input('item_content');

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $thumb_name = "";
        if($item_rank == "") $item_rank = 0;

        //DB 저장 배열 만들기
        $data = array(
            'ca_id'         => $last_choice_ca_id,
            'item_code'     => $item_code,
            'item_name'     => $item_name,
            'item_display'  => $item_display,
            'item_rank'     => $item_rank,
            'item_content'  => $item_content,
        );

        if($request->hasFile('item_img'))
        {
            $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

            $item_img = $request->file('item_img');
            $file_type = $item_img->getClientOriginalExtension();    //이미지 확장자 구함
            $file_size = $item_img->getSize();  //첨부 파일 사이즈 구함

            //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
            $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

            //첨부 파일 용량 예외처리
            Validator::validate($request->all(), [
                'item_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
            ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

            $path = 'data/item';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($item_img,$path); //위의 패스로 이미지 저장됨

            if(!$attachment_result[0])
            {
                return redirect()->route('adm.cate.create')->with('alert_messages', $Messages::$file_chk['file_chk']['message']['file_false']);
                exit;
            }else{
                for($k = 0; $k < 3; $k++){
                    $resize_width_file_tmp = explode("%%","500%%300%%100");
                    $resize_height_file_tmp = explode("%%","500%%300%%100");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                $data['item_ori_img'] = $attachment_result[2];  //배열에 추가 함
                $data['item_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
            }
        }

        //저장 처리
        $create_result = items::create($data);
        $create_result->save();

        if($create_result = 1) return redirect(route('adm.cate.index'))->with('alert_messages', $Messages::$item['insert']['in_ok']);
        else return redirect(route('adm.cate.index'))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
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
