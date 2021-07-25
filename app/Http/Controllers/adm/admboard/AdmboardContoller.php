<?php
#############################################################################
#
#		파일이름		:		AdminboardController.php
#		파일설명		:		관리자페이지 게시판 control
#		저작권			:		저작권은 제작자 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 16일
#		최종수정일		:		2021년 07월 20일
#
###########################################################################-->

namespace App\Http\Controllers\adm\admboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Models\User;    //모델 정의
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크
use App\Models\board_datas_table;    //게시판 모델 정의

class AdmboardContoller extends Controller
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

    public function index($tb_name,Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();

        //글쓰기 삭제 등등 게시판 쎄팅값 처리
        //관리자 페이지 이지만 나중에 프론트로 copy 할때를 위해 똑같이 개발(21.07.16)
        if(Auth::user()->user_level == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //글list 제어
        if($user_level > $board_set_info->bm_list_chk){
            return redirect()->route('adm.admboard.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_list_chk']);
            exit;
        }

        $cate        = $request->input('cate');
        $pageNum     = $request->input('page');
        $writeList   = 10;  //10갯씩 뿌리기
        $pageNumList = 10; // 한 페이지당 표시될 글 갯수
        $type = 'board';

        $page_control = CustomUtils::page_function('board_datas_tables',$pageNum,$writeList,$pageNumList,$type,$tb_name,$cate);

        if($cate == ""){
            $board_lists = DB::table('board_datas_tables')->where('bm_tb_name',$tb_name)->orderby('bdt_grp', 'DESC')->orderby('bdt_sort')->skip($page_control['startNum'])->take($writeList)->get();
        }else{
            $board_lists = DB::table('board_datas_tables')->where([['bm_tb_name',$tb_name],['bdt_category',$cate]])->orderby('bdt_grp', 'DESC')->orderby('bdt_sort')->skip($page_control['startNum'])->take($writeList)->get();
        }

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        //글쓰기 버튼 제어
        $write_button = "";
        if($user_level <= $board_set_info->bm_write_chk){
            $write_button = "<td><button type='button' onclick=\"location.href='/adm/admboard/write/$board_set_info->bm_tb_name'\">{$Messages::$board['b_ment']['b_write_ment']}</button></td>";
        }

        //선택 삭제 제어
        $choice_del_button = "";
        if($user_level == config('app.ADMIN_LEVEL')){
            $choice_del_button = "<td><button type='button' onclick='choice_del();'>{$Messages::$board['b_ment']['b_choice_del_ment']}</button></td>";
        }

        //카테고리 제어
        $selected_val = '';
        $route_link = " onchange='category();' ";

        $select_disp = "";
        if(trim($board_set_info->bm_category_key) != ""){
            $select_disp = CustomUtils::select_box('bdt_category', $board_set_info->bm_category_ment, $board_set_info->bm_category_key, $cate, $route_link);
        }

        return view('adm.admboard.admboardlist',[
            'tb_name'                   => $tb_name,
            'board_set_info'            => $board_set_info, //게시판 쎄팅 배열
            'board_lists'               => $board_lists, //게시판 내용
            'write_button'              => $write_button,
            'choice_del_button'         => $choice_del_button,
            'virtual_num'               => $page_control['virtual_num'],
            'totalCount'                => $page_control['totalCount'],
            'pageNum'                   => $page_control['pageNum'],
            'pageList'                  => $pageList,
            'select_disp'               => $select_disp,
            'cate'                      => $cate,
        ],$Messages::$mypage['mypage']['message']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tb_name)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();

        if(Auth::user()->user_level == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //글쓰기 권한 제어
        if($user_level > $board_set_info->bm_write_chk){
            return redirect()->route('adm.admboard.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_write_chk']);
            exit;
        }

        if(Auth::user()->user_id == "") $user_id = "";
        else $user_id = Auth::user()->user_id;

        //카테고리 제어
        $selected_val = '';
        $select_disp = "";
        if(trim($board_set_info->bm_category_key) != ""){
            $select_disp = CustomUtils::select_box('bdt_category', $board_set_info->bm_category_ment, $board_set_info->bm_category_key, $selected_val,'');
        }

        return view('adm.admboard.admboardwrite',[
            'tb_name'                   => $tb_name,
            'board_set_info'            => $board_set_info,
            'user_level'                => $user_level,
            'user_id'                   => $user_id,
            'select_disp'               => $select_disp,
        ],$Messages::$mypage['mypage']['message']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $tb_name = $request->input('tb_name');

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user()->user_level == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //글쓰기 권한 제어
        if($user_level > $board_set_info->bm_write_chk){
            return redirect()->route('adm.admboard.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_write_chk']);
            exit;
        }

        //아이디 처리
        if(Auth::user()->user_id == '') $bdt_uid = $request->input('bdt_uid');
        else $bdt_uid = Auth::user()->user_id;

        //이름 처리
        if(Auth::user()->user_name == '') $bdt_uname = $request->input('bdt_uname');
        else $bdt_uname = Auth::user()->user_name;

        $bdt_subject = addslashes($request->input('bdt_subject'));
        $bdt_chk_secret = $request->input('bdt_chk_secret');

        if ($request->has('bdt_chk_secret')) {
            $bdt_chk_secret = 1;
        }else{
            $bdt_chk_secret = 0;
        }

        $bdt_category = $request->input('bdt_category');
        if(trim($request->input('bdt_upw')) != "")
        {
            $bdt_upw = md5(trim($request->input('bdt_upw')));
        }else{
            $bdt_upw = "";
        }

        $bdt_content = $request->input('bdt_content');

        $file_cnt = $board_set_info->bm_file_num;    //설정시 사용할 첨부 갯수
        $file_max_size = $board_set_info->bm_resize_max_size;   //게시판 설정에서 첨부 파일 용량제한

        $bdt_ip = $_SERVER["REMOTE_ADDR"];

        //DB 저장 배열 만들기
        $data = array(
            'bm_tb_name' => $tb_name,
            'bdt_chk_secret' => $bdt_chk_secret,
            'bdt_uid' => $bdt_uid,
            'bdt_uname' => $bdt_uname,
            'bdt_upw' => $bdt_upw,
            'bdt_subject' => $bdt_subject,
            'bdt_content' => $bdt_content,
            'bdt_category' => $bdt_category,
            'bdt_ip' => $bdt_ip,
            'bdt_sort' => 0,
            'bdt_depth' => 0,
        );

        for($i = 1; $i <= $file_cnt; $i++){
            if($request->hasFile('bdt_file'.$i))
            {
                $fileExtension = ['jpeg','jpg','png','gif','bmp', "GIF", "PNG", "JPG", "JPEG", "BMP"];  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

                $bdt_file[$i] = $request->file('bdt_file'.$i);
                $file_type = $bdt_file[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $bdt_file[$i]->getSize();  //첨부 파일 사이즈 구함

                //게시판 설정에서 첨부 파일 용량제한 에 따라 변경
                if($file_max_size != null || $file_max_size != 0){
                    $max_size_mb = $file_max_size * 1024;   //라라벨은 kb 단위라 함
                    //첨부 파일 용량 예외처리
                    Validator::validate($request->all(), [
                        'bdt_file'.$i  => ['max:'.$max_size_mb]
                    ], [$file_max_size."MB 까지만 저장 가능 합니다."]);
                }

                $path = 'data/board/'.$tb_name;     //첨부물 저장 경로
                $attachment_result = CustomUtils::attachment_save($bdt_file[$i],$path); //위의 패스로 이미지 저장됨

                $check = in_array($file_type,$fileExtension);   //첨부가 이미지 정해 놓은 이미지 배열 안에 있는지 파악
                if($check){
                    //첨부물 이미지 일때
                    //서버에 올라간 파일을 썸네일 만든다.
                    //게시판 쎄팅에서 리사이징 갯수가 있는지 파악
                    if($board_set_info->bm_resize_file_num != null || $board_set_info->bm_resize_file_num != 0)
                    {
                        //리사이징이 있을때(썸네일 만들기)
                        $thumb_name = "";

                        for($k = 0; $k < $board_set_info->bm_resize_file_num; $k++){
                            $resize_width_file_tmp = explode("%%",$board_set_info->bm_resize_width_file);
                            $resize_height_file_tmp = explode("%%",$board_set_info->bm_resize_height_file);

                            $thumb_width = $resize_width_file_tmp[$k];
                            $thumb_height = $resize_height_file_tmp[$k];

                            $is_create = false;
                            $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                        }
                    }

                    $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                    $data['bdt_file'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                }else{
                    //첨부물 이미지가 아닐때
                    $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                    $data['bdt_file'.$i] = $attachment_result[1];  //배열에 추가 함
                }
            }
        }

        //저장 처리
        $create_result = board_datas_table::create($data);
        $create_result['bdt_grp'] = $create_result->id; //저장된 결과 값에 auto increment 값을 찾을때 사용
        $create_result->save();

        if($create_result = 1) return redirect('adm/admboard/list/'.$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_save']);
        else return redirect('adm/admboard/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tb_name,Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //$tb_name = $request->input('tb_name');    request로 넘어온 값이 아님

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user()->user_level == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //글보기 권한 제어
        if($user_level > $board_set_info->bm_view_chk){
            return redirect()->route('adm.admboard.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_view_chk']);
            exit;
        }

        $board_info = DB::table('board_datas_tables')->where([['id', $request->input('id')], ['bm_tb_name',$tb_name]])->first();   //게시판 정보 읽기

        //비밀글 처리
        $result_pw      = $request->input('pw');  //비밀글 비번 찾기를 통해 온 결과 값(secretpw 함수)
        $cate           = $request->input('cate');
        $page           = $request->input('page');

        if($user_level > config('app.ADMIN_LEVEL') || Auth::user()->user_id != $board_info->bdt_uid){    //관리자가 아니거나 본인 글이 아닐시 비번 묻기
            if($board_info->bdt_chk_secret == 1 && $result_pw != 'ok'){
                return redirect()->route('adm.admboard.secret',$tb_name.'?id='.$board_info->id.'&page='.$page.'&cate='.$cate);
            }
        }

        //조회수
        $b_up = board_datas_table::whereid($request->input('id'))->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $b_up->bdt_hit = $b_up->bdt_hit + 1;
        $result_up = $b_up->save();

        //비밀글일경우 때문에 다시 게시판 정보 읽기(비밀글일경우 비번이 맞아야 읽는 것이니 게시판 정보 읽고 조회수 누적 시키면 누적되기 전 값이 출력됨, 그래서 다시 정보 읽어서 출력)
        $board_info_display = DB::table('board_datas_tables')->where([['id', $request->input('id')], ['bm_tb_name',$tb_name]])->first();   //게시판 정보 읽기

        //카테고리명 출력(카테고리가 있는 게시판 이라면)
        $category_ment = "";
        if(trim($board_set_info->bm_category_key) != ""){
            $category_tmp = explode("@@",$board_set_info->bm_category_ment);
            $category_ment = $category_tmp[$board_info->bdt_category - 1];
        }

        //글쓰기 버튼 제어
        $write_button = "";
        if($user_level <= $board_set_info->bm_write_chk){
            //$write_button = "<td><button type='button' onclick=\"location.href='/adm/admboard/write/$board_set_info->bm_tb_name'\">{$Messages::$board['b_ment']['b_write_ment']}</button></td>";
            $write_button = "<td><button type='button' onclick=\"location.href='/adm/admboard/write/$board_set_info->bm_tb_name'\">{$Messages::$board['b_ment']['b_write_ment']}</button></td>";
        }

        //답글 쓰기 버튼 제어
        $reply_button = "";
        if($user_level <= $board_set_info->bm_reply_chk){
            $reply_button = "<td><button type='button' onclick=\"location.href='/adm/admboard/reply/$board_set_info->bm_tb_name/$board_info->id'\">{$Messages::$board['b_ment']['b_reply_ment']}</button></td>";
        }

        return view('adm.admboard.admboardview',[
            'tb_name'                   => $tb_name,
            'category_ment'             => $category_ment,
            'board_set_info'            => $board_set_info,
            'board_info'                => $board_info_display, //게시판 내용
            'write_button'              => $write_button,
            'reply_button'              => $reply_button,
        ],$Messages::$mypage['mypage']['message']);
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

    public function choice_del(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $tb_name = $request->input('tb_name');
        $path = 'data/board/'.$tb_name;     //첨부물 저장 경로

        $board_set_info = DB::table('boardmanagers')->select('bm_file_num')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 정보에서 첨부 파일 갯수 구하기

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            //선택된 게시물 일괄 삭제
            //먼저 게시물을 검사하여 파일이 있는지 파악 하고 같이 삭제 함
            $board_info = DB::table('board_datas_tables')->where([['id', $request->input('chk_id')[$i]], ['bm_tb_name',$tb_name]])->first();

            for($m = 1; $m <= $board_set_info->bm_file_num; $m++){
                $bdt_file = 'bdt_file'.$m;
                if($board_info->$bdt_file != ""){
                    $file_cnt = explode('@@',$board_info->$bdt_file);

                    for($j = 0; $j < count($file_cnt); $j++){
                        $img_path = "";
                        $img_path = $path.'/'.$file_cnt[$j];
                        if (file_exists($img_path)) {
                            @unlink($img_path); //이미지 삭제
                        }
                    }
                }
            }

            DB::table('board_datas_tables')->where('id',$request->input('chk_id')[$i])->delete();   //row 삭제
        }
        return redirect()->route('adm.admboard.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_del']);
    }

    public function secret($tb_name,Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id = $request->input('id');
        $page = $request->input('page');
        $cate = $request->input('cate');

        return view('adm.admboard.admboardsecret',[
            'tb_name'                   => $tb_name,
            'b_id'                      => $id,
            'page'                      => $page,
            'cate'                      => $cate,
        ],$Messages::$board['b_ment']);
    }

    public function secretpw(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $tb_name = $request->input('tb_name');
        $b_id = $request->input('b_id');
        $upw = $request->input('upw');
        $page = $request->input('page');
        $cate = $request->input('cate');

        if($tb_name == "" || $b_id == "" || $upw == ""){
            //예외 처리
            return redirect()->route('adm.admboard.index',$tb_name);
            exit;
        }

        $board_info = DB::table('board_datas_tables')->where([['id', $b_id], ['bm_tb_name',$tb_name]])->first();    //게시물 정보 추출

        if(md5($upw) != $board_info->bdt_upw){
            return redirect()->route('adm.admboard.show',$tb_name.'?id='.$board_info->id.'&page='.$page.'&cate='.$cate)->with('alert_messages', $Messages::$board['b_ment']['b_pwno']);
            exit;
        }else{
            $request['id'] = $b_id;
            $request['page'] = $page;
            $request['cate'] = $cate;
            $request['pw'] = "ok";

            return self::show($tb_name,$request);   //함수에 직접 전달
            exit;
        }
    }

    public function downloadfile(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $tb_name = $request->input('tb_name');
        $b_id = $request->input('b_id');
        $file_num = $request->input('file_num');

        $bdt_ori_file = "bdt_ori_file_name$file_num";
        $bdt_file = "bdt_file$file_num";

        $board_info = DB::table('board_datas_tables')->select($bdt_ori_file, $bdt_file)->where([['id', $b_id], ['bm_tb_name',$tb_name]])->first();    //게시물 정보 추출

        $file_cut = explode("@@",$board_info->$bdt_file);
        $path = 'data/board/'.$tb_name;     //첨부물 저장 경로

        $down_file = public_path($path.'/'.$file_cut[0]);

        //다운로드 수(일단 한게시물에 전체 파일 중 하나 다운 받아도 횟수 올라 가게 개발)
        $b_up = board_datas_table::whereid($b_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $b_up->bdt_down_cnt = $b_up->bdt_down_cnt + 1;
        $result_up = $b_up->save();

        return response()->download($down_file, $board_info->$bdt_ori_file);
    }

    public function reply($tb_name, $ori_num, Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();

        if(Auth::user()->user_level == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        if(Auth::user()->user_id == "") $user_id = "";
        else $user_id = Auth::user()->user_id;

        //답글 쓰기 제어
        if($user_level > $board_set_info->bm_reply_chk){
            return redirect()->route('adm.admboard.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_reply_chk']);
            exit;
        }

        //원본글 내용 구함
        $board_ori_info = DB::table('board_datas_tables')->select('bdt_grp','bdt_sort','bdt_depth','bdt_category','bdt_subject','bdt_content')->where([['id', $ori_num], ['bm_tb_name',$tb_name]])->first();    //게시물 정보 추출

        return view('adm.admboard.admboardreply',[
            'tb_name'                   => $tb_name,
            'ori_num'                   => $ori_num,
            'user_level'                => $user_level,
            'user_id'                   => $user_id,
            'board_ori_info'            => $board_ori_info,
            'board_set_info'            => $board_set_info,
        ],$Messages::$board['b_ment']);

    }

    public function replysave($tb_name, Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user()->user_level == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //답글쓰기 권한 제어
        if($user_level > $board_set_info->bm_reply_chk){
            return redirect()->route('adm.admboard.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_reply_chk']);
            exit;
        }

        //아이디 처리
        if(Auth::user()->user_id == '') $bdt_uid = $request->input('bdt_uid');
        else $bdt_uid = Auth::user()->user_id;

        //이름 처리
        if(Auth::user()->user_name == '') $bdt_uname = $request->input('bdt_uname');
        else $bdt_uname = Auth::user()->user_name;

        $bdt_subject = addslashes($request->input('bdt_subject'));
        $bdt_chk_secret = $request->input('bdt_chk_secret');

        if ($request->has('bdt_chk_secret')) {
            $bdt_chk_secret = 1;
        }else{
            $bdt_chk_secret = 0;
        }

        $bdt_category = $request->input('bdt_category');
        if(trim($request->input('bdt_upw')) != "")
        {
            $bdt_upw = md5(trim($request->input('bdt_upw')));
        }else{
            $bdt_upw = "";
        }

        $bdt_content = $request->input('bdt_content');

        $file_cnt = $board_set_info->bm_file_num;    //설정시 사용할 첨부 갯수
        $file_max_size = $board_set_info->bm_resize_max_size;   //게시판 설정에서 첨부 파일 용량제한

        $bdt_ip = $_SERVER["REMOTE_ADDR"];

        $bdt_grp = $request->input('bdt_grp');
        $bdt_sort = $request->input('bdt_sort');
        $bdt_depth = $request->input('bdt_depth');
        $bdt_category = $request->input('bdt_category');

        $aa = board_datas_table::where([
            ['bdt_grp',$bdt_grp],
            ['bdt_sort','>',$bdt_sort],
        ])->increment('bdt_sort', 1);

        //DB 저장 배열 만들기
        $data = array(
            'bm_tb_name' => $tb_name,
            'bdt_chk_secret' => $bdt_chk_secret,
            'bdt_uid' => $bdt_uid,
            'bdt_uname' => $bdt_uname,
            'bdt_upw' => $bdt_upw,
            'bdt_subject' => $bdt_subject,
            'bdt_content' => $bdt_content,
            'bdt_category' => $bdt_category,
            'bdt_ip' => $bdt_ip,
            'bdt_sort' => $bdt_sort + 1,
            'bdt_depth' => $bdt_depth + 1,
        );

        for($i = 1; $i <= $file_cnt; $i++){
            if($request->hasFile('bdt_file'.$i))
            {
                $fileExtension = ['jpeg','jpg','png','gif','bmp', "GIF", "PNG", "JPG", "JPEG", "BMP"];  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

                $bdt_file[$i] = $request->file('bdt_file'.$i);
                $file_type = $bdt_file[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $bdt_file[$i]->getSize();  //첨부 파일 사이즈 구함

                //게시판 설정에서 첨부 파일 용량제한 에 따라 변경
                if($file_max_size != null || $file_max_size != 0){
                    $max_size_mb = $file_max_size * 1024;   //라라벨은 kb 단위라 함
                    //첨부 파일 용량 예외처리
                    Validator::validate($request->all(), [
                        'bdt_file'.$i  => ['max:'.$max_size_mb]
                    ], [$file_max_size."MB 까지만 저장 가능 합니다."]);
                }

                $path = 'data/board/'.$tb_name;     //첨부물 저장 경로
                $attachment_result = CustomUtils::attachment_save($bdt_file[$i],$path); //위의 패스로 이미지 저장됨

                $check = in_array($file_type,$fileExtension);   //첨부가 이미지 정해 놓은 이미지 배열 안에 있는지 파악
                if($check){
                    //첨부물 이미지 일때
                    //서버에 올라간 파일을 썸네일 만든다.
                    //게시판 쎄팅에서 리사이징 갯수가 있는지 파악
                    if($board_set_info->bm_resize_file_num != null || $board_set_info->bm_resize_file_num != 0)
                    {
                        //리사이징이 있을때(썸네일 만들기)
                        $thumb_name = "";

                        for($k = 0; $k < $board_set_info->bm_resize_file_num; $k++){
                            $resize_width_file_tmp = explode("%%",$board_set_info->bm_resize_width_file);
                            $resize_height_file_tmp = explode("%%",$board_set_info->bm_resize_height_file);

                            $thumb_width = $resize_width_file_tmp[$k];
                            $thumb_height = $resize_height_file_tmp[$k];

                            $is_create = false;
                            $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                        }
                    }

                    $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                    $data['bdt_file'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                }else{
                    //첨부물 이미지가 아닐때
                    $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                    $data['bdt_file'.$i] = $attachment_result[1];  //배열에 추가 함
                }
            }
        }

        //저장 처리
        $create_result = board_datas_table::create($data);
//        $create_result['bdt_grp'] = $create_result->id; //저장된 결과 값에 auto increment 값을 찾을때 사용
//        $create_result->save();

        if($create_result = 1) return redirect('adm/admboard/list/'.$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_save']);
        else return redirect('adm/admboard/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
    }


}



