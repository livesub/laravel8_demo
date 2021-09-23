<?php
#############################################################################
#
#		파일이름		:		BoardController.php
#		파일설명		:		프론트 게시판 모쥴 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers\board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크
use App\Models\board_datas_table;    //게시판 모델 정의
use App\Models\board_datas_comment_table;    //게시판 모델 정의

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tb_name,Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();

        //글쓰기 삭제 등등 게시판 쎄팅값 처리
        //관리자 페이지 이지만 나중에 프론트로 copy 할때를 위해 똑같이 개발(21.07.16)
        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //글list 제어
        if($user_level > $board_set_info->bm_list_chk){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_list_chk']);
            exit;
        }

        $cate        = $request->input('cate');
        $pageNum     = $request->input('page');
        $writeList   = $board_set_info->bm_record_num;  //페이지당 글수
        $pageNumList = $board_set_info->bm_page_num; //블럭당 페이지수

        $type = 'board';

        //검색 처리
        $keymethod = $request->input('keymethod');
        $keyword = $request->input('keyword');

        $search_sql = "";
        if($keymethod != "" && $keyword != ""){
            if($keymethod == "all"){
                $search_sql = " AND (bdt_subject LIKE '%{$keyword}%' OR bdt_content LIKE '%{$keyword}%') ";
            }else{
                $search_sql = " AND {$keymethod} LIKE '%{$keyword}%' ";
            }
        }

        $cate_sql = "";
        if($cate != ""){
            $cate_sql = " AND bdt_category = '{$cate}'";
        }

        $page_control = CustomUtils::page_function('board_datas_tables',$pageNum,$writeList,$pageNumList,$type,$tb_name,$cate,$keymethod,$keyword);

        $board_lists = DB::select("select * from board_datas_tables where bm_tb_name = '{$tb_name}' {$cate_sql} {$search_sql} order by bdt_grp desc, bdt_sort asc limit {$page_control['startNum']} , {$writeList}");

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        //글쓰기 버튼 제어
        $write_button = "";
        if($user_level <= $board_set_info->bm_write_chk){
            $write_button = "<td><button type='button' onclick=\"location.href='/board/write/$board_set_info->bm_tb_name'\">{$Messages::$board['b_ment']['b_write_ment']}</button></td>";
        }

        //선택 삭제 제어
        $choice_del_button = "";
        if($user_level <= config('app.ADMIN_LEVEL')){
            $choice_del_button = "<td><button type='button' onclick='choice_del();'>{$Messages::$board['b_ment']['b_choice_del_ment']}</button></td>";
        }

        //카테고리 제어
        $selected_val = '';
        $route_link = " onchange='category();' ";

        $select_disp = "";
        if(trim($board_set_info->bm_category_key) != ""){
            $select_disp = CustomUtils::select_box('bdt_category', $board_set_info->bm_category_ment, $board_set_info->bm_category_key, $cate, $route_link);
        }

        //게시판 종류 체크(일반게시판, 갤러리 게시판)
        if($board_set_info->bm_type == 1){
            $list_blade = "skin.".$board_set_info->bm_skin.".list";
        }else{
            $list_blade = "skin.".$board_set_info->bm_skin.".list";
        }

        return view($list_blade,[
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
            'keymethod'                 => $keymethod,
            'keyword'                   => $keyword,
        ],$Messages::$mypage['mypage']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tb_name)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //글쓰기 권한 제어
        if($user_level > $board_set_info->bm_write_chk){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_write_chk']);
            exit;
        }

        if(Auth::user() == "") $user_id = "";
        else $user_id = Auth::user()->user_id;

        //카테고리 제어
        $selected_val = '';
        $select_disp = "";
        if(trim($board_set_info->bm_category_key) != ""){
            $select_disp = CustomUtils::select_box('bdt_category', $board_set_info->bm_category_ment, $board_set_info->bm_category_key, $selected_val,'');
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $tb_name_directory = "data/board/{$tb_name}/editor";
        setcookie('directory', $tb_name_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        //현재 리스트를 제외한 스킨은 공통으로 쓰고 있음
        $write_blade = "skin.".$board_set_info->bm_skin.".write";

        return view($write_blade,[
            'tb_name'               => $tb_name,
            'board_set_info'        => $board_set_info,
            'user_level'            => $user_level,
            'user_id'               => $user_id,
            'select_disp'           => $select_disp,
        ],$Messages::$mypage['mypage']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $tb_name = $request->input('tb_name');

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //글쓰기 권한 제어
        if($user_level > $board_set_info->bm_write_chk){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_write_chk']);
            exit;
        }

        //아이디 처리
        if(Auth::user() == '') $bdt_uid = $request->input('bdt_uid');
        else $bdt_uid = Auth::user()->user_id;

        //이름 처리
        if(Auth::user() == '') $bdt_uname = $request->input('bdt_uname');
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
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $bdt_ip = $_SERVER["REMOTE_ADDR"];

        //DB 저장 배열 만들기
        $data = array(
            'bm_tb_name'        => $tb_name,
            'bdt_chk_secret'    => $bdt_chk_secret,
            'bdt_uid'           => $bdt_uid,
            'bdt_uname'         => $bdt_uname,
            'bdt_upw'           => $bdt_upw,
            'bdt_subject'       => $bdt_subject,
            'bdt_content'       => $bdt_content,
            'bdt_category'      => $bdt_category,
            'bdt_ip'            => $bdt_ip,
            'bdt_sort'          => 0,
            'bdt_depth'         => 0,
        );

        for($i = 1; $i <= $file_cnt; $i++){
            if($request->hasFile('bdt_file'.$i))
            {
                $fileExtension = ['jpeg','jpg','png','gif','bmp', "GIF", "PNG", "JPG", "JPEG", "BMP"];  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

                $bdt_file[$i] = $request->file('bdt_file'.$i);
                $file_type = $bdt_file[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $bdt_file[$i]->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함
                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'bdt_file'.$i  => ['max:'.$max_size_mb]
                ], [$upload_max_filesize."MB 까지만 저장 가능 합니다."]);

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

                        $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                        $data['bdt_file'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함
                    }else{
                        //리사이징이 없을때
                        $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                        $data['bdt_file'.$i] = $attachment_result[1];  //배열에 추가 함
                    }
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

        if($create_result) return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_save']);
        else return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tb_name,Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //$tb_name = $request->input('tb_name');    request로 넘어온 값이 아님

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //글보기 권한 제어
        if($user_level > $board_set_info->bm_view_chk){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_view_chk']);
            exit;
        }

        $board_info = DB::table('board_datas_tables')->where([['id', $request->input('id')], ['bm_tb_name',$tb_name]])->first();   //게시판 정보 읽기

        //비밀글 처리
        $result_pw      = $request->input('pw');  //비밀글 비번 찾기를 통해 온 결과 값(secretpw 함수)
        $cate           = $request->input('cate');
        $page           = $request->input('page');
        $mode           = $request->input('mode');
        $keymethod      = $request->input('keymethod');
        $keyword        = $request->input('keyword');

        //관리자가 아니거나 본인 글이 아닐시 비번 묻기
        if($user_level > config('app.ADMIN_LEVEL')) //일반 사용자
        {
            if(Auth::user() == ""){     //비회원일때
                if($board_info->bdt_chk_secret == 1 && $result_pw != 'ok'){     //비밀글이라면
                    return redirect()->route('board.secret',$tb_name.'?id='.$board_info->id.'&page='.$page.'&cate='.$cate);
                }
            }else{  //회원일때
                if(Auth::user()->user_id != $board_info->bdt_uid){  //본인 글이 아니고
                    //먼저 답글인지 파악
                    //답글일때 회원 작성 글은 비밀번호가 없고, 자신의 글에 답변은 볼수 있게 하기 위해
                    if($board_info->bdt_depth > 0){
                        if($board_info->bdt_chk_secret == 1){ //비밀글일때
                            //원본글 작성자 찾기
                            $board_ori_info = DB::table('board_datas_tables')->select("bdt_uid")->where([['id', $board_info->bdt_grp], ['bm_tb_name',$tb_name], ['bdt_depth',0]])->first();
                            if(Auth::user()->user_id != $board_ori_info->bdt_uid ){
                                return redirect()->route('board.secret',$tb_name.'?id='.$board_info->id.'&page='.$page.'&cate='.$cate);
                            }
                        }
                    }else{
                        if($board_info->bdt_chk_secret == 1 && $result_pw != 'ok'){     //비밀글이라면
                            return redirect()->route('board.secret',$tb_name.'?id='.$board_info->id.'&page='.$page.'&cate='.$cate);
                        }
                    }
                }
            }
        }

        //조회수
        $b_up = board_datas_table::whereid($request->input('id'))->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $b_up->bdt_hit = $b_up->bdt_hit + 1;
        $result_up = $b_up->save();

        //비밀글일경우 때문에 다시 게시판 정보 읽기(비밀글일경우 비번이 맞아야 읽는 것이니 게시판 정보 읽고 조회수 누적 시키면 누적되기 전 값이 출력됨, 그래서 다시 정보 읽어서 출력)
        $board_info_display = DB::table('board_datas_tables')->where([['id', $request->input('id')], ['bm_tb_name',$tb_name]])->first();   //게시판 정보 읽기

        //page 처리
        $page_link = "";
        if($page != ""){
            $page_link = "?page=".$page;
        }

        //카테고리명 출력(카테고리가 있는 게시판 이라면)
        $category_ment = "";
        $cate_link = "";
        if(trim($board_set_info->bm_category_key) != ""){
            $category_tmp = explode("@@",$board_set_info->bm_category_ment);
            $category_ment = $category_tmp[$board_info->bdt_category - 1];
            $cate_link = "&cate=".$cate;
        }

        //검색어 처리
        $search_link = "";
        if($keymethod != "" && $keyword != ""){
            $search_link = "&keymethod=".$keymethod."&keyword=".$keyword;
        }

        //버튼 초기화
        $write_button = "";
        $reply_button = "";
        $modi_button = "";
        $del_button = "";
        $list_button = "";

        //글쓰기 버튼 제어
        if($user_level <= $board_set_info->bm_write_chk){
            $write_button = "<td><button type='button' onclick=\"location.href='/board/write/$board_set_info->bm_tb_name$page_link$cate_link$search_link'\">{$Messages::$board['b_ment']['b_write_ment']}</button></td>";
        }

        //버튼 제어
        if(Auth::user() != "" && Auth::user()->user_level <= config('app.ADMIN_LEVEL')){    //관리자일때
            //답글 쓰기 버튼 제어
            $reply_button = "<td><button type='button' onclick=\"location.href='/board/reply/$board_set_info->bm_tb_name/$board_info->id$page_link$cate_link$search_link'\">{$Messages::$board['b_ment']['b_reply_ment']}</button></td>";

            //수정 버튼 제어
            $modi_button = "<td><button type='button' onclick=\"location.href='/board/modify/$board_set_info->bm_tb_name/$board_info->id$page_link$cate_link$search_link'\">{$Messages::$board['b_ment']['b_modi_ment']}</button></td>";

            //삭제 버튼 제어
            $del_button = "<td><button type='button' onclick='b_del();'>{$Messages::$board['b_ment']['b_del_ment']}</button></td>";
        }else{
            //답글 쓰기 버튼 제어
            if($user_level <= $board_set_info->bm_reply_chk){
                $reply_button = "<td><button type='button' onclick=\"location.href='/board/reply/$board_set_info->bm_tb_name/$board_info->id$page_link$cate_link$search_link'\">{$Messages::$board['b_ment']['b_reply_ment']}</button></td>";
            }

            //수정 버튼 제어
            if($user_level <= $board_set_info->bm_modify_chk){  //수정 권한이 있는 게시판인지
                if(Auth::user() == ""){     //비회원 일때
                    $modi_button = "<td><button type='button' onclick=\"location.href='/board/modify/$board_set_info->bm_tb_name/$board_info->id$page_link$cate_link$search_link'\">{$Messages::$board['b_ment']['b_modi_ment']}</button></td>";
                }else{      //회원일때
                    if(Auth::user()->user_id == $board_info->bdt_uid){
                        $modi_button = "<td><button type='button' onclick=\"location.href='/board/modify/$board_set_info->bm_tb_name/$board_info->id$page_link$cate_link$search_link'\">{$Messages::$board['b_ment']['b_modi_ment']}</button></td>";
                    }
                }
            }

            //삭제 버튼 제어
            if($user_level <= $board_set_info->bm_delete_chk){  //삭제 권한이 있는 게시판인지
                if(Auth::user() == ""){     //비회원 일때
                    $del_button = "<td><button type='button' onclick='b_del();'>{$Messages::$board['b_ment']['b_del_ment']}</button></td>";
                }else{      //회원일때
                    if(Auth::user()->user_id == $board_info->bdt_uid){
                        $del_button = "<td><button type='button' onclick='b_del();'>{$Messages::$board['b_ment']['b_del_ment']}</button></td>";
                    }
                }
            }
        }

        //목록 버튼 제어
        if($user_level <= $board_set_info->bm_list_chk){  //삭제 권한이 있는 게시판인지
            $list_button = "<td><button type='button' onclick=\"location.href='/board/list/$board_set_info->bm_tb_name$page_link$cate_link$search_link'\">{$Messages::$board['b_ment']['b_list_ment']}</button></td>";
        }

        $comment_infos = DB::table('board_datas_comment_tables')->where([['bdt_id', $request->input('id')], ['bm_tb_name',$tb_name]])->orderby('bdct_grp', 'DESC')->orderby('bdct_sort')->get();   //댓글 정보 읽기

        $view_blade = "skin.".$board_set_info->bm_skin.".view";

        return view($view_blade,[
            'tb_name'           => $tb_name,
            'category_ment'     => $category_ment,
            'board_set_info'    => $board_set_info,
            'board_info'        => $board_info_display, //게시판 내용
            'write_button'      => $write_button,
            'reply_button'      => $reply_button,
            'modi_button'       => $modi_button,
            'del_button'        => $del_button,
            'list_button'       => $list_button,
            'page'              => $page,
            'cate'              => $cate,
            'b_id'              => $request->input('id'),
            'comment_infos'     => $comment_infos,
        ],$Messages::$mypage['mypage']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletesave($tb_name, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //$tb_name = $request->input('tb_name');    request로 넘어온 값이 아님

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //삭제 권한 제어
        if($user_level > $board_set_info->bm_delete_chk){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_del_chk']);
            exit;
        }

        $b_id           = $request->input('b_id');
        $mode           = $request->input('mode');
        $result_pw      = $request->input('pw');  //비밀글 비번 찾기를 통해 온 결과 값(secretpw 함수)

        $board_set_info = DB::table('boardmanagers')->select('bm_file_num')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 정보에서 첨부 파일 갯수 구하기
        $board_info = DB::table('board_datas_tables')->where([['id', $b_id], ['bm_tb_name',$tb_name]])->first();   //게시판 정보 읽기

        //관리자가 아니거나 본인 글이 아닐시 비번 묻기
        if($user_level > config('app.ADMIN_LEVEL'))
        {
            if(Auth::user() == "" || Auth::user()->user_id != $board_info->bdt_uid){
                if($board_info->bdt_chk_secret == "0" && $result_pw != 'ok'){ //비밀글이 아닐경우
                    return redirect()->route('board.secret',$tb_name.'?id='.$board_info->id.'&mode=del');
                }else{  //비밀글일 경우
                    if($board_info->bdt_chk_secret == 1 && $result_pw != 'ok'){
                        return redirect()->route('board.secret',$tb_name.'?id='.$board_info->id.'&mode=del');
                    }
                }
            }
        }

       $path = 'data/board/'.$tb_name;     //첨부물 저장 경로
       $editor_path = $path."/editor";     //스마트 에디터 첨부 저장 경로

        //스마트 에디터 내용에 첨부된 이미지 색제
        $editor_img_del = CustomUtils::editor_img_del($board_info->bdt_content, $editor_path);

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

        //답글이 달린 글이면 삭제 하지 않고(bdt_del 플러그 값 Y로 바꾸고, 제목,내용,글쓴이 등등 'null' 업뎃  첨부물은 삭제)
        //댓글이 있는지 파악
        $board_sort = DB::table('board_datas_tables')->where([['bdt_grp', $board_info->bdt_grp], ['bm_tb_name',$tb_name],['bdt_sort','>',$board_info->bdt_sort]])->count();
        if($board_sort >= 1){   //댓글이 있는 상태
            $data = array(
                'bdt_uid'           => '',
                'bdt_uname'         => '',
                'bdt_upw'           => '',
                'bdt_subject'       => '삭제된 글입니다.',
                'bdt_content'       => '',
                'bdt_hit'           => 0,
                'bdt_comment_cnt'   => 0,
                'bdt_down_cnt'      => 0,
                'bdt_del'           => 'Y',
            );

            for($p = 1; $p <= $board_set_info->bm_file_num; $p++){  //단순 첨부 파일 DB 만 지우기 위해
                $data['bdt_ori_file_name'.$p] = '';  //배열에 추가 함
                $data['bdt_file'.$p] = '';  //배열에 추가 함
            }
            $update_result = DB::table('board_datas_tables')->where('id', $b_id)->limit(1)->update($data);
        }else{
            DB::table('board_datas_tables')->where('id',$b_id)->delete();   //row 삭제
        }

        //답글이 있던 없던 댓글은 삭제 한다.
        $bdct_del = DB::table('board_datas_comment_tables')->where([['bdt_id',$b_id],['bm_tb_name',$tb_name]])->delete();   //게시판 댓글 row 삭제

        return redirect()->route('board.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_del']);
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
        $editor_path = $path."/editor";     //스마트 에디터 첨부 저장 경로

        $board_set_info = DB::table('boardmanagers')->select('bm_file_num')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 정보에서 첨부 파일 갯수 구하기

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            //선택된 게시물 일괄 삭제
            //먼저 게시물을 검사하여 파일이 있는지 파악 하고 같이 삭제 함
            $board_info = DB::table('board_datas_tables')->where([['id', $request->input('chk_id')[$i]], ['bm_tb_name',$tb_name]])->first();

            //스마트 에디터 내용에 첨부된 이미지 색제
            $editor_img_del = CustomUtils::editor_img_del($board_info->bdt_content, $editor_path);

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

            //답글이 달린 글이면 삭제 하지 않고(bdt_del 플러그 값 Y로 바꾸고, 제목,내용,글쓴이 등등 'null' 업뎃  첨부물은 삭제)
            //답글이 있는지 파악
            $board_sort = DB::table('board_datas_tables')->where([['bdt_grp', $board_info->bdt_grp], ['bm_tb_name',$tb_name],['bdt_sort','>',$board_info->bdt_sort]])->count();
            if($board_sort >= 1){   //답글이 있는 상태
                $data = array(
                    'bdt_uid'           => '',
                    'bdt_uname'         => '',
                    'bdt_upw'           => '',
                    'bdt_subject'       => '삭제된 글입니다.',
                    'bdt_content'       => '',
                    'bdt_hit'           => 0,
                    'bdt_comment_cnt'   => 0,
                    'bdt_down_cnt'      => 0,
                    'bdt_del'           => 'Y',
                );

                for($p = 1; $p <= $board_set_info->bm_file_num; $p++){  //단순 첨부 파일 DB 만 지우기 위해
                    $data['bdt_ori_file_name'.$p] = null;  //배열에 추가 함
                    $data['bdt_file'.$p] = null;  //배열에 추가 함
                }
                $update_result = DB::table('board_datas_tables')->where('id', $request->input('chk_id')[$i])->limit(1)->update($data);

            }else{
                DB::table('board_datas_tables')->where('id',$request->input('chk_id')[$i])->delete();   //row 삭제
            }

            //답글이 있던 없던 댓글은 삭제 한다.
            $bdct_del = DB::table('board_datas_comment_tables')->where([['bdt_id',$request->input('chk_id')[$i]],['bm_tb_name',$tb_name]])->delete();   //게시판 댓글 row 삭제
        }
        return redirect()->route('board.index',$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_del']);
    }

    public function secret($tb_name,Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id   = $request->input('id');
        $page = $request->input('page');
        $cate = $request->input('cate');
        $mode = $request->input('mode');

        return view('board.boardsecret',[
            'tb_name'                   => $tb_name,
            'b_id'                      => $id,
            'page'                      => $page,
            'cate'                      => $cate,
            'mode'                      => $mode,
        ],$Messages::$board['b_ment']);
    }

    public function secretpw(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $tb_name = $request->input('tb_name');
        $b_id = $request->input('b_id');
        $upw = $request->input('upw');
        $page = $request->input('page');
        $cate = $request->input('cate');
        $mode = $request->input('mode');

        if($tb_name == "" || $b_id == "" || $upw == ""){
            //예외 처리
            //return redirect()->route('board.index',$tb_name);
            return redirect()->back();
            exit;
        }

        $board_info = DB::table('board_datas_tables')->where([['id', $b_id], ['bm_tb_name',$tb_name]])->first();    //게시물 정보 추출

        if(md5($upw) != $board_info->bdt_upw){
            return redirect()->route('board.show',$tb_name.'?id='.$board_info->id.'&page='.$page.'&cate='.$cate)->with('alert_messages', $Messages::$board['b_ment']['b_pwno']);
            exit;
        }else{
            $request['id'] = $b_id;
            $request['page'] = $page;
            $request['cate'] = $cate;
            $request['pw'] = "ok";
            $request['mode'] = $mode;

            if($mode == 'modi'){
                return self::modify($tb_name,$b_id,$request);   //함수에 직접 전달
            }else if($mode == 'del'){
                return self::deletesave($tb_name,$request);   //함수에 직접 전달
            }else{
                return self::show($tb_name,$request);   //함수에 직접 전달
            }

            exit;
        }
    }

    public function downloadfile(Request $request)
    {
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
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        if(Auth::user() == "") $user_id = "";
        else $user_id = Auth::user()->user_id;

        //답글 쓰기 제어
        if($user_level > $board_set_info->bm_reply_chk){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_reply_chk']);
            exit;
        }

        //원본글 내용 구함
        $board_ori_info = DB::table('board_datas_tables')->select('bdt_grp','bdt_sort','bdt_depth','bdt_category','bdt_subject','bdt_content','bdt_chk_secret')->where([['id', $ori_num], ['bm_tb_name',$tb_name]])->first();    //게시물 정보 추출

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $tb_name_directory = "data/board/{$tb_name}/editor";
        setcookie('directory', $tb_name_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $reply_blade = "skin.".$board_set_info->bm_skin.".reply";

        return view($reply_blade,[
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
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //답글쓰기 권한 제어
        if($user_level > $board_set_info->bm_reply_chk){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_reply_chk']);
            exit;
        }

        //관리자 답글시 비번은 원본글 비번으로
        $ori_num = $request->input('ori_num');  //원본글 번호

        //원본글 작성자 비번 찾기
        $board_ori_info = DB::table('board_datas_tables')->select("bdt_upw","bdt_chk_secret")->where([['id', $ori_num], ['bm_tb_name',$tb_name], ['bdt_depth',0]])->first();

        if(Auth::user() != "" && $user_level <= config('app.ADMIN_LEVEL')){     //관리자일때
            $bdt_uid = Auth::user()->user_id;
            $bdt_uname = Auth::user()->user_name;

            if($board_ori_info == "") $bdt_upw = "";
            else $bdt_upw = $board_ori_info->bdt_upw;
        }else{
            //일반 사용자일 경우(회,비회 포함)
            //아이디 처리
            if(Auth::user() == '') $bdt_uid = $request->input('bdt_uid');
            else $bdt_uid = Auth::user()->user_id;

            //이름 처리
            if(Auth::user() == '') $bdt_uname = $request->input('bdt_uname');
            else $bdt_uname = Auth::user()->user_name;

            //비밀번호 처리
            if(Auth::user() == '') $bdt_upw = md5(trim($request->input('bdt_upw')));
            else{   //비밀글일때 일반 회원이 비밀글에 답변 달때 원본 글의 비번 넣는다
                if($board_ori_info->bdt_chk_secret == 1) $bdt_upw = $board_ori_info->bdt_upw;
                else $bdt_upw = "";
            }
        }

        $bdt_subject = addslashes($request->input('bdt_subject'));
        $bdt_chk_secret = $request->input('bdt_chk_secret');

        if ($request->has('bdt_chk_secret')) {
            $bdt_chk_secret = 1;
        }else{
            $bdt_chk_secret = 0;
        }

        $bdt_category = $request->input('bdt_category');
        $bdt_content = $request->input('bdt_content');

        $file_cnt = $board_set_info->bm_file_num;    //설정시 사용할 첨부 갯수
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $bdt_ip = $_SERVER["REMOTE_ADDR"];

        $bdt_grp = $request->input('bdt_grp');
        $bdt_sort = $request->input('bdt_sort');
        $bdt_depth = $request->input('bdt_depth');
        $bdt_category = $request->input('bdt_category');

        $bdt_sort_up = board_datas_table::where([
            ['bdt_grp',$bdt_grp],
            ['bdt_sort','>',$bdt_sort],
        ])->increment('bdt_sort', 1);

        //DB 저장 배열 만들기
        $data = array(
            'bm_tb_name'        => $tb_name,
            'bdt_chk_secret'    => $bdt_chk_secret,
            'bdt_uid'           => $bdt_uid,
            'bdt_uname'         => $bdt_uname,
            'bdt_upw'           => $bdt_upw,
            'bdt_subject'       => $bdt_subject,
            'bdt_content'       => $bdt_content,
            'bdt_category'      => $bdt_category,
            'bdt_ip'            => $bdt_ip,
            'bdt_grp'           => $bdt_grp,
            'bdt_sort'          => $bdt_sort + 1,
            'bdt_depth'         => $bdt_depth + 1,
        );

        for($i = 1; $i <= $file_cnt; $i++){
            if($request->hasFile('bdt_file'.$i))
            {
                $fileExtension = ['jpeg','jpg','png','gif','bmp', "GIF", "PNG", "JPG", "JPEG", "BMP"];  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

                $bdt_file[$i] = $request->file('bdt_file'.$i);
                $file_type = $bdt_file[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $bdt_file[$i]->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함
                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'bdt_file'.$i  => ['max:'.$max_size_mb]
                ], [$upload_max_filesize."MB 까지만 저장 가능 합니다."]);

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

                        $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                        $data['bdt_file'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함
                    }else{
                        //리사이징이 없을때
                        $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                        $data['bdt_file'.$i] = $attachment_result[1];  //배열에 추가 함
                    }
                }else{
                    //첨부물 이미지가 아닐때
                    $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                    $data['bdt_file'.$i] = $attachment_result[1];  //배열에 추가 함
                }
            }
        }

        //저장 처리
        $create_result = board_datas_table::create($data);
        $bdt_category_url = "";
        if($bdt_category != ""){    //키테고리 있을때
            $bdt_category_url = "?cate=".$bdt_category;
        }

        if($create_result) return redirect('board/list/'.$tb_name.$bdt_category_url)->with('alert_messages', $Messages::$board['b_ment']['b_save']);
        else return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function modify($tb_name, $ori_num, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //$tb_name = $request->input('tb_name');    request로 넘어온 값이 아님

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //수정 권한 제어
        if($user_level > $board_set_info->bm_modify_chk){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_view_chk']);
            exit;
        }

        $board_info = DB::table('board_datas_tables')->where([['id', $ori_num], ['bm_tb_name',$tb_name]])->first();   //게시판 정보 읽기

        //비밀글 처리
        $result_pw      = $request->input('pw');  //비밀글 비번 찾기를 통해 온 결과 값(secretpw 함수)
        $cate           = $request->input('cate');
        $page           = $request->input('page');

        //관리자가 아니거나 본인 글이 아닐시 비번 묻기
        if($user_level > config('app.ADMIN_LEVEL'))
        {
            if(Auth::user() == "" || Auth::user()->user_id != $board_info->bdt_uid){
                if($board_info->bdt_chk_secret == "0" && $result_pw != 'ok'){ //비밀글이 아닐경우
                    return redirect()->route('board.secret',$tb_name.'?id='.$board_info->id.'&page='.$page.'&cate='.$cate.'&mode=modi');
                }else{  //비밀글일 경우
                    if($board_info->bdt_chk_secret == 1 && $result_pw != 'ok'){
                        return redirect()->route('board.secret',$tb_name.'?id='.$board_info->id.'&page='.$page.'&cate='.$cate.'&mode=modi');
                    }
                }
            }
        }

        //아이디 처리
        if(Auth::user() == "") $user_id = "";
        else $user_id = Auth::user()->user_id;

        $select_disp = "";
        if(trim($board_set_info->bm_category_key) != ""){
            $select_disp = CustomUtils::select_box('bdt_category', $board_set_info->bm_category_ment, $board_set_info->bm_category_key, $board_info->bdt_category, '');
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $tb_name_directory = "data/board/{$tb_name}/editor";
        setcookie('directory', $tb_name_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $modify_blade = "skin.".$board_set_info->bm_skin.".modify";

        return view($modify_blade,[
            'tb_name'           => $tb_name,
            'ori_num'           => $ori_num,
            'user_level'        => $user_level,
            'user_id'           => $user_id,
            'select_disp'       => $select_disp,
            'board_info'        => $board_info,
            'board_set_info'    => $board_set_info,
        ],$Messages::$board['b_ment']);
    }

    public function modifysave($tb_name, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기
        $board_info = DB::table('board_datas_tables')->where([['id', $request->input('b_id')], ['bm_tb_name',$tb_name]])->first();   //게시판 정보 읽기

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //$bdt_chk_secret = $request->input('bdt_chk_secret');

        //아이디 처리(관리자가 수정 할땐 아이디, 이름과 비번은 바꾸지 않는다)
        if(Auth::user() != "" && Auth::user()->user_level == config('app.ADMIN_LEVEL')){    //관리자일때
            $bdt_uid = $board_info->bdt_uid;
            $bdt_uname = $board_info->bdt_uname;
            $bdt_upw = $board_info->bdt_upw;
        }else{  //관리자가 아닐때
            if(Auth::user() == '') $bdt_uid = $request->input('bdt_uid');
            else $bdt_uid = Auth::user()->user_id;

            //이름 처리
            if(Auth::user() == '') $bdt_uname = $request->input('bdt_uname');
            else $bdt_uname = Auth::user()->user_name;

            //비밀번호 처리
            if(Auth::user() == '') $bdt_upw = md5(trim($request->input('bdt_upw')));
            else $bdt_upw = "";
        }

        if ($request->has('bdt_chk_secret')) {
            $bdt_chk_secret = 1;
        }else{
            $bdt_chk_secret = 0;
        }

        $bdt_subject = addslashes($request->input('bdt_subject'));
        $bdt_category = $request->input('bdt_category');
        $bdt_content = $request->input('bdt_content');

        $file_cnt = $board_set_info->bm_file_num;    //설정시 사용할 첨부 갯수
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $bdt_ip = $_SERVER["REMOTE_ADDR"];

        //DB 저장 배열 만들기
        $data = array(
            'bm_tb_name'        => $tb_name,
            'bdt_chk_secret'    => $bdt_chk_secret,
            'bdt_uid'           => $bdt_uid,
            'bdt_uname'         => $bdt_uname,
            'bdt_upw'           => $bdt_upw,
            'bdt_subject'       => $bdt_subject,
            'bdt_content'       => $bdt_content,
            'bdt_category'      => $bdt_category,
            'bdt_ip'            => $bdt_ip,
        );

        $path = 'data/board/'.$tb_name;     //첨부물 저장 경로
        $fileExtension = ['jpeg','jpg','png','gif','bmp', "GIF", "PNG", "JPG", "JPEG", "BMP"];  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        for($i = 1; $i <= $file_cnt; $i++){
            $file_chk_tmp = 'file_chk'.$i;
            $file_chk = $request->input($file_chk_tmp); //수정,삭제,새로등록 체크 파악
            if($file_chk == 1){ //체크된 것들만 액션
                if($request->hasFile('bdt_file'.$i))    //첨부가 있음
                {
                    $bdt_file[$i] = $request->file('bdt_file'.$i);
                    $file_type = $bdt_file[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                    $file_size = $bdt_file[$i]->getSize();  //첨부 파일 사이즈 구함

                    //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                    $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함
                    //첨부 파일 용량 예외처리
                    Validator::validate($request->all(), [
                        'bdt_file'.$i  => ['max:'.$max_size_mb]
                    ], [$upload_max_filesize."MB 까지만 저장 가능 합니다."]);

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

                            $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                            $data['bdt_file'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함
                        }else{
                            //리사이징이 없을때
                            $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                            $data['bdt_file'.$i] = $attachment_result[1];  //배열에 추가 함
                        }
                    }else{
                        //첨부물 이미지가 아닐때
                        $data['bdt_ori_file_name'.$i] = $attachment_result[2];  //배열에 추가 함
                        $data['bdt_file'.$i] = $attachment_result[1];  //배열에 추가 함
                    }

                    $bdt_file_tmp = 'bdt_file'.$i;
                    if($board_info->$bdt_file_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                        $file_cnt1 = explode('@@',$board_info->$bdt_file_tmp);
                        for($j = 0; $j < count($file_cnt1); $j++){
                            $img_path = "";
                            $img_path = $path.'/'.$file_cnt1[$j];
                            if (file_exists($img_path)) {
                                @unlink($img_path); //이미지 삭제
                            }
                        }
                    }
                }else{  //첨부가 없음
                    $bdt_file_tmp = 'bdt_file'.$i;
                    if($board_info->$bdt_file_tmp != ""){   //기존 첨부가 있는지 파악 - 첨부 파일 없이 들어 온것은 기존 파일 삭제로 간주
                        $file_cnt1 = explode('@@',$board_info->$bdt_file_tmp);
                        for($j = 0; $j < count($file_cnt1); $j++){
                            $img_path = "";
                            $img_path = $path.'/'.$file_cnt1[$j];
                            if (file_exists($img_path)) {
                                @unlink($img_path); //이미지 삭제
                            }
                        }

                        $data['bdt_ori_file_name'.$i] = "";  //배열에 추가 함
                        $data['bdt_file'.$i] = "";  //배열에 추가 함
                    }

                }
            }
        }

        //$update_result = DB::table('board_datas_tables')->where('id', $request->input('b_id'))->limit(1)->update($data);
        $update_result = Board_datas_table::find($request->input('b_id'))->update($data);

        if($update_result) return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$board['b_ment']['b_save']);
        else return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function commentsave($tb_name, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_set_info = DB::table('boardmanagers')->where('bm_tb_name', $tb_name)->first();   //게시판 설정 가져 오기

        if(Auth::user() == "") $user_level = "100";
        else $user_level = Auth::user()->user_level;

        //댓글 권한 제어(회원만 댓글 가능)
        if(Auth::user()->user_level == "" || $board_set_info->bm_coment_type != 1){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['b_comment_chk']);
            exit;
        }

        $cate = $request->input('cate');
        $page = $request->input('page');
        $b_id = $request->input('b_id');

        //$board_info = DB::table('board_datas_tables')->where([['id', $b_id], ['bm_tb_name',$tb_name]])->first();   //게시판 정보 읽기

        //아이디 처리
        if(Auth::user()->user_id == '') $bdct_uid = "";
        else $bdct_uid = Auth::user()->user_id;

        //이름 처리
        if(Auth::user()->user_name == '') $bdct_uname = '';
        else $bdct_uname = Auth::user()->user_name;

        $bdct_memo = $request->input('bdct_memo');
        $bdct_ip = $_SERVER["REMOTE_ADDR"];


        //DB 저장 배열 만들기
        $data = array(
            'bm_tb_name'    => $tb_name,
            'bdt_id'        => $b_id,
            'bdct_uid'      => $bdct_uid,
            'bdct_uname'    => $bdct_uname,
            'bdct_memo'     => $bdct_memo,
            'bdct_ip'       => $bdct_ip,
            'bdct_sort'     => 0,
            'bdct_depth'    => 0,
        );

        $create_result = board_datas_comment_table::create($data);
        $create_result['bdct_grp'] = $create_result->id; //저장된 결과 값에 auto increment 값을 찾을때 사용
        $create_result->save();

        //원본글에 댓글 갯수 업뎃
        $b_up = board_datas_table::whereid($b_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $b_up->bdt_comment_cnt = $b_up->bdt_comment_cnt + 1;
        $result_up = $b_up->save();

        if($create_result) return redirect('board/view/'.$tb_name.'?id='.$b_id.'&page='.$page.'&cate='.$cate)->with('alert_messages', $Messages::$board['b_ment']['b_save']);
        else return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }


    public function commemtreplysave($tb_name, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $cate     = $request->input('cate');
        $page     = $request->input('page');
        $b_id     = $request->input('b_id');    //원본글

        $c_id     = $request->input('c_id');    //댓글 원본
        $bdct_memo = $request->input('bdct_memo_reply');
        $bdct_grp = $request->input('bdct_grp');
        $bdct_sort = $request->input('bdct_sort');
        $bdct_depth = $request->input('bdct_depth');

        //아이디 처리
        if(Auth::user()->user_id == '') $bdct_uid = "";
        else $bdct_uid = Auth::user()->user_id;

        //이름 처리
        if(Auth::user()->user_name == '') $bdct_uname = '';
        else $bdct_uname = Auth::user()->user_name;

        $bdct_ip = $_SERVER["REMOTE_ADDR"];

        $bdct_sort_up = board_datas_comment_table::where([
            ['bdct_grp',$bdct_grp],
            ['bdct_sort','>',$bdct_sort],
        ])->increment('bdct_sort', 1);

        //DB 저장 배열 만들기
        $data = array(
            'bm_tb_name'    => $tb_name,
            'bdt_id'        => $b_id,
            'bdct_uid'      => $bdct_uid,
            'bdct_uname'    => $bdct_uname,
            'bdct_memo'     => $bdct_memo,
            'bdct_grp'      => $bdct_grp,
            'bdct_sort'     => $bdct_sort + 1,
            'bdct_depth'    => $bdct_depth + 1,
            'bdct_ip'       => $bdct_ip,
        );

        //저장 처리
        $create_result = board_datas_comment_table::create($data);

        //원본글에 댓글 갯수 업뎃
        $b_up = board_datas_table::whereid($b_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $b_up->bdt_comment_cnt = $b_up->bdt_comment_cnt + 1;
        $result_up = $b_up->save();

        $id_link = "?id=".$b_id;
        $page_link = "&page=".$page;
        $cate_url = "";
        if($cate != ""){    //키테고리 있을때
            $cate_url = "&cate=".$cate;
        }

        if($create_result) return redirect('board/view/'.$tb_name.$id_link.$page_link.$cate_url)->with('alert_messages', $Messages::$board['b_ment']['b_save']);
        else return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function commemtmodifysave($tb_name, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $cate     = $request->input('cate');
        $page     = $request->input('page');
        $b_id     = $request->input('b_id');    //원본글
        $c_id     = $request->input('c_id');    //댓글 원본

        $bdct_memo = $request->input('bdct_memo_reply');

        $c_up = board_datas_comment_table::whereid($c_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $c_up->bdct_memo = $bdct_memo;
        $result_up = $c_up->save();

        $id_link = "?id=".$b_id;
        $page_link = "&page=".$page;
        $cate_url = "";
        if($cate != ""){    //키테고리 있을때
            $cate_url = "&cate=".$cate;
        }

        if($result_up = 1) return redirect('board/view/'.$tb_name.$id_link.$page_link.$cate_url)->with('alert_messages', $Messages::$board['b_ment']['b_modi']);
        else return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function commemtdelete($tb_name, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $cate     = $request->input('cate');
        $page     = $request->input('page');
        $b_id     = $request->input('b_id');    //원본글
        $c_id     = $request->input('c_id');    //댓글 원본

        //답글이 달린 글이면 삭제 하지 않고(bdct_del 플러그 값 Y로 바꾸고, 제목,내용,글쓴이 등등 'null' 업뎃  첨부물은 삭제)
        $b_c_info = DB::table('board_datas_comment_tables')->select('bdct_grp','bdct_sort')->where([['id', $c_id], ['bm_tb_name',$tb_name]])->first();
        $b_comment_sort = DB::table('board_datas_comment_tables')->where([['bdct_grp', $b_c_info->bdct_grp], ['bm_tb_name',$tb_name],['bdct_sort','>',$b_c_info->bdct_sort]])->count();
        if($b_comment_sort >= 1){   //댓글이 있는 상태
            $data = array(
                'bdct_uid'      => '',
                'bdct_uname'    => '',
                'bdct_memo'     => '삭제된 글입니다.',
                'bdct_del'      => 'Y',
            );
            $update_result = DB::table('board_datas_comment_tables')->where('id', $c_id)->limit(1)->update($data);
        }else{
            $result_del = DB::table('board_datas_comment_tables')->where('id',$c_id)->delete();   //row 삭제

            //원본글에 댓글 갯수 업뎃
            $b_up = board_datas_table::whereid($b_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
            $b_up->bdt_comment_cnt = $b_up->bdt_comment_cnt - 1;
            $result_up = $b_up->save();
        }

        $id_link = "?id=".$b_id;
        $page_link = "&page=".$page;
        $cate_url = "";
        if($cate != ""){    //키테고리 있을때
            $cate_url = "&cate=".$cate;
        }

        if($result_del = 1) return redirect('board/view/'.$tb_name.$id_link.$page_link.$cate_url)->with('alert_messages', $Messages::$board['b_ment']['b_del']);
        else return redirect('board/list/'.$tb_name)->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시

    }
}