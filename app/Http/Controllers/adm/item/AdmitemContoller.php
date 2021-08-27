<?php
#############################################################################
#
#		파일이름		:		AdmitemController.php
#		파일설명		:		관리자 상품 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers\adm\item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\items;    //상품 모델 정의
use Validator;  //체크
use App\Models\categorys;    //카테고리 모델 정의

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

    public function index(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));


        $pageNum     = $request->input('page');
        $writeList   = 10;  //페이지당 글수
        $pageNumList = 10; //블럭당 페이지수

        $tb_name = "items";
        $type = 'items';
        $cate = "";

        //검색 selectbox 만들기
        $search_selectboxs = DB::table('categorys')->orderby('ca_rank','DESC')->orderby('ca_id','ASC')->get();

        //검색 처리
        $cate_search    = $request->input('cate_search');
        $item_search    = $request->input('item_search');
        $keyword        = $request->input('keyword');

        if($item_search == "") $item_search = "item_name";
        $search_sql = "";

        if($cate_search != ""){
            $search_sql = " AND a.ca_id = b.ca_id AND a.ca_id LIKE '{$cate_search}%' AND a.{$item_search} LIKE '%{$keyword}%' ";
        }else{
            $search_sql .= " AND a.ca_id = b.ca_id AND a.{$item_search} LIKE '%{$keyword}%' ";
        }

        $page_control = CustomUtils::page_function('items',$pageNum,$writeList,$pageNumList,$type,$tb_name,$cate_search,$item_search,$keyword);

        $item_infos = DB::select("select a.*, b.ca_id from items a, categorys b where 1 {$search_sql} order by a.id DESC, a.item_rank ASC limit {$page_control['startNum']}, {$writeList} ");

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.item.itemlist',[
            'item_infos'        => $item_infos,
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
            'cate_search'       => $cate_search,
            'item_search'       => $item_search,
            'keyword'           => $keyword,
            'search_selectboxs' => $search_selectboxs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
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
        $item_directory = "data/item/editor";
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
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id     = $request->input('ca_id');
        $length     = $request->input('length');

        if($ca_id == "" && $length == ""){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

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
                $output = '<select name="ca_id" size="10" id="caa_id2"class="cid"  >';
            }elseif($length == '4'){
                $output = '<select name="ca_id" size="10" id="caa_id3"class="cid" >';
            }elseif($length == '6'){
                $output = '<select name="ca_id" size="10" id="caa_id4"class="cid" >';
            }elseif($length == '8'){
                $output = '<select name="ca_id" size="10" id="caa_id5"class="cid" >';
            }elseif($length == '10'){
                $output = '<select name="ca_id" size="10" id="caa_id6"class="cid" >';
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
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
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
                return redirect()->route('adm.item.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
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

        if($create_result = 1) return redirect(route('adm.item.index'))->with('alert_messages', $Messages::$item['insert']['in_ok']);
        else return redirect(route('adm.item.index'))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function choice_del(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $path = 'data/item';     //첨부물 저장 경로
        $editor_path = $path."/editor";     //스마트 에디터 첨부 저장 경로

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            //선택된 상품 일괄 삭제
            //먼저 상품을 검사하여 파일이 있는지 파악 하고 같이 삭제 함
            $item_info = DB::table('items')->where('id', $request->input('chk_id')[$i])->first();

            //스마트 에디터 내용에 첨부된 이미지 색제
            $editor_img_del = CustomUtils::editor_img_del($item_info->item_content, $editor_path);

            //첨부 파일 삭제
            $item_img = $item_info->item_img;
            if($item_img != ""){
                $file_cnt = explode('@@',$item_img);

                for($j = 0; $j < count($file_cnt); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }

            DB::table('items')->where('id',$request->input('chk_id')[$i])->delete();   //row 삭제
        }
        return redirect()->route('adm.item.index')->with('alert_messages', $Messages::$item['del']['del_ok']);
    }

    public function modify(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id = $request->input('id');
        $ca_id = $request->input('ca_id');

        if($id == "" && $ca_id == ""){
            return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
            exit;
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $item_directory = "data/item/editor";
        setcookie('directory', $item_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $item_info = DB::table('items')->where([['id',$id],['ca_id',$ca_id]])->first();

        //1단계 가져옴
        $one_str_cut = substr($item_info->ca_id,0,2);
        $one_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 2')->orderby('ca_id', 'ASC')->get();


        //2단계 가져옴
        $two_str_cut = substr($item_info->ca_id,0,4);
        $two_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where([['ca_display','Y'],['ca_id','like',$one_str_cut.'%']])->whereRaw('length(ca_id) = 4')->orderby('ca_id', 'ASC')->get();

        //3단계 가져옴
        $three_str_cut = substr($item_info->ca_id,0,6);
        $three_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where([['ca_display','Y'],['ca_id','like',$two_str_cut.'%']])->whereRaw('length(ca_id) = 6')->orderby('ca_id', 'ASC')->get();

        //4단계 가져옴
        $four_str_cut = substr($item_info->ca_id,0,8);
        $four_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where([['ca_display','Y'],['ca_id','like',$three_str_cut.'%']])->whereRaw('length(ca_id) = 8')->orderby('ca_id', 'ASC')->get();

        //5단계 가져옴
        $five_str_cut = substr($item_info->ca_id,0,10);
        $five_step_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where([['ca_display','Y'],['ca_id','like',$four_str_cut.'%']])->whereRaw('length(ca_id) = 10')->orderby('ca_id', 'ASC')->get();

        return view('adm.item.itemmodify',[
            'one_step_infos'    => $one_step_infos,
            'two_step_infos'    => $two_step_infos,
            'three_step_infos'  => $three_step_infos,
            'four_step_infos'   => $four_step_infos,
            'five_step_infos'   => $five_step_infos,
            'item_info'         => $item_info,
            'ca_id'             => $ca_id,
            'one_str_cut'       => $one_str_cut,
            'two_str_cut'       => $two_str_cut,
            'three_str_cut'     => $three_str_cut,
            'four_str_cut'      => $four_str_cut,
            'five_str_cut'      => $five_str_cut,
        ]);
    }

    public function downloadfile(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id = $request->input('id');
        $ca_id = $request->input('ca_id');

        $item_info = DB::table('items')->select('item_img','item_ori_img')->where([['id', $id], ['ca_id',$ca_id]])->first();    //상품 정보 추출

        $file_cut = explode("@@",$item_info->item_img);
        $path = 'data/item';     //첨부물 저장 경로
        $down_file = public_path($path.'/'.$file_cut[0]);
        return response()->download($down_file, $item_info->item_ori_img);
    }

    public function modifysave(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id                 = $request->input('id');
        $ca_id              = $request->input('ca_id');
        $length             = $request->input('length');
        $last_choice_ca_id  = $request->input('last_choice_ca_id');
        $item_code          = $request->input('item_code');
        $item_name          = addslashes($request->input('item_name'));
        $item_display       = $request->input('item_display');
        $item_rank          = $request->input('item_rank');
        $item_content       = $request->input('item_content');

        if($id == "" && $ca_id == "" && $last_choice_ca_id == ""){
            return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
            exit;
        }

        if(!isset($_COOKIE['directory'])){  //쿠키 값이 사라진 후에 저장 되지 않게
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        $path = 'data/item';     //첨부물 저장 경로

        $thumb_name = "";
        if($item_rank == "") $item_rank = 0;

        $item_info = DB::table('items')->where('id', $id)->first(); //기존 상품 정보

        //DB 저장 배열 만들기
        $data = array(
            'ca_id'         => $last_choice_ca_id,
            'item_code'     => $item_code,
            'item_name'     => $item_name,
            'item_display'  => $item_display,
            'item_rank'     => $item_rank,
            'item_content'  => $item_content,
        );

        $file_chk = $request->input('file_chk1'); //수정,삭제,새로등록 체크 파악
        if($file_chk == 1){ //체크된 것들만 액션
            if($request->hasFile('item_img'))    //첨부가 있음
            {
                $item_img = $request->file('item_img');
                $file_type = $item_img->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $item_img->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'item_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                $attachment_result = CustomUtils::attachment_save($item_img,$path); //위의 패스로 이미지 저장됨
                if(!$attachment_result[0])
                {
                    return redirect()->route('adm.item.index')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
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
            }else{
                $data['item_ori_img'] = "";  //배열에 추가 함
                $data['item_img'] = "";  //배열에 추가 함
            }

            if($item_info->item_img != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                $file_cnt1 = explode('@@',$item_info->item_img);
                for($j = 0; $j < count($file_cnt1); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt1[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }
        }

        $update_result = DB::table('items')->where('id', $id)->limit(1)->update($data);

        if($update_result = 1) return redirect(route('adm.item.index'))->with('alert_messages', $Messages::$item['update']['up_ok']);
        else return redirect(route('adm.item.index'))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

}
