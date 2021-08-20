<?php

namespace App\Http\Controllers\adm\admemail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크
use App\Models\emails;    //이메일 내용 모델 정의
use App\Models\email_sends;    //이메일 발송 정보
use Illuminate\Support\Str;

class AdmemailContoller extends Controller
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
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $pageNum     = $request->input('page');
        $writeList   = 15;  //페이지당 글수
        $pageNumList = 15; //블럭당 페이지수

        $page_control = CustomUtils::page_function('emails',$pageNum,$writeList,$pageNumList,'email','','','','');

        //이메일 읽기
        $email_lists = DB::table('emails')->orderby('id', 'DESC')->skip($page_control['startNum'])->take($writeList)->get();

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.email.emaillist',[
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            "email_lists"       => $email_lists,
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
        ],$Messages::$mypage['mypage']['message']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $directory = "email/editor";
        setcookie('directory', $directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        //첨부 파일 저장소
        $target_path = "data/email";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        return view('adm.email.emailcreate',[
        ],$Messages::$mypage['mypage']['message']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createsave(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //스마트 에디터 쿠키 때문에 일정 시간 지나면 글 못쓰게
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $email_subject = addslashes($request->input('email_subject'));
        $email_content = $request->input('email_content');

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        //DB 저장 배열 만들기
        $data = array(
            'email_subject' => $email_subject,
            'email_content' => $email_content,
        );

        for($i = 1; $i <= 2; $i++){
            if($request->hasFile('email_file'.$i))
            {
                $email_file[$i] = $request->file('email_file'.$i);

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함
                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'email_file'.$i  => ['max:'.$max_size_mb]
                ], [$upload_max_filesize."MB 까지만 저장 가능 합니다."]);

                $path = 'data/email';     //첨부물 저장 경로
                $attachment_result = CustomUtils::attachment_save($email_file[$i],$path); //위의 패스로 이미지 저장됨

                $data['email_ori_file'.$i] = $attachment_result[2];  //배열에 추가 함
                $data['email_file'.$i] = $attachment_result[1];  //배열에 추가 함
            }
        }

        //저장 처리
        $create_result = emails::create($data);
        $create_result->save();

        if($create_result = 1) return redirect()->route('adm.admemail.index')->with('alert_messages', $Messages::$email['e_ment']['e_save']);
        else return redirect()->route('adm.admemail.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
    }

    public function choice_del(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $path = 'data/email';     //첨부물 저장 경로
        $editor_path = $path."/editor";     //스마트 에디터 첨부 저장 경로

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            //선택된 게시물 일괄 삭제
            $email_info = DB::table('emails')->where('id', $request->input('chk_id')[$i])->first();

            //스마트 에디터 내용에 첨부된 이미지 색제
            $editor_img_del = CustomUtils::editor_img_del($email_info->email_content, $editor_path);

            //첨부파일 삭제
            for($m = 1; $m <= 2; $m++){
                $email_file = 'email_file'.$m;
                if($email_info->$email_file != ""){
                    $img_path = "";
                    $img_path = $path.'/'.$email_info->$email_file;
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }

            DB::table('emails')->where('id',$request->input('chk_id')[$i])->delete();   //row 삭제(본문)
            DB::table('email_sends')->where('email_id',$request->input('chk_id')[$i])->delete();   //row 삭제(발송자명단)
        }

        return redirect()->route('adm.admemail.index')->with('alert_messages', $Messages::$email['e_ment']['e_del']);
    }

    public function send_mem_chk(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id = $request->input('id');

        //이메일 인증이 완료된 회원과 관리자, 탈퇴 회원을 제외한 회원을 뽑아 온다
        //$user_lists = DB::table('users')->select('id','user_id','user_name','user_phone')->where([['user_level','>',config('app.ADMIN_LEVEL')],['user_type','N']])->whereRaw('user_confirm_code is null')->orderby('id', 'DESC')->get();
        //테스트 용도\
        $user_lists = DB::table('users')->select('id','user_id','user_name','user_phone')->whereRaw('user_confirm_code is null')->orderby('id', 'DESC')->get();


        return view('adm.email.emailmemberchk',[
            'user_lists'    => $user_lists,
            'email_id'      => $id,
        ],$Messages::$mypage['mypage']['message']);
    }

    public function send_ok(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $email_id = $request->input('email_id');

        $email_info = DB::table('emails')->where('id', $email_id)->first();     //이메일 재목,내용등
        $email_subject = stripslashes($email_info->email_subject);

        //첨부 파일 생성
        $m = 0;
        $files = array();
        for($k = 1; $k <= 2; $k++){
            $email_file = 'email_file'.$k;

            if($email_info->$email_file != ""){
                $files[$m] = public_path('data/email/'.$email_info->$email_file);
                $m++;
            }
        }

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            $mem_info = DB::table('users')->select('user_id','user_name')->where('id',$request->input('chk_id')[$i])->first();   //회원 아이디 등등
            $user_id = $mem_info->user_id;
            $user_name = $mem_info->user_name;

            $subject = sprintf('[%s 회원님]'.$email_subject, $user_name);
            $email_receive_token = Str::random(10);

            $data["email"] = $user_id;
            $data["name"] = $user_name;
            $data["subject"] = $subject;
            $data["body"] = $email_info->email_content;
            $data["receive_token"] = $email_receive_token;

            //이메일 함수 이용 발송
            $email_send_value = CustomUtils::email_mem_send("adm.email.email_mem_send", $data, $files);
            if(!$email_send_value)
            {
                $email_send_chk = 'N';
            }else{
                $email_send_chk = 'Y';
            }

            //DB 저장 배열 만들기
            $data_send = array(
                'email_id'              => $email_id,
                'email_user_id'         => $user_id,
                'email_send_chk'        => $email_send_chk,
                'email_receive_chk'     => 'N',
                'email_receive_token'   => $email_receive_token,
            );

            //저장 처리
            $create_result = email_sends::create($data_send);
            $create_result->save();
        }

        if($create_result = 1) return redirect()->route('adm.admemail.index')->with('alert_messages', $Messages::$email['e_ment']['email_send']);
        else return redirect()->route('adm.admemail.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
    }

    public function modify(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $directory = "email/editor";
        setcookie('directory', $directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        //첨부 파일 저장소
        $target_path = "data/email";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        $email_info = DB::table('emails')->where('id', $request->input('id'))->first();   //게시판 정보 읽기

        return view('adm.email.emailmodify',[
            "email_info"       => $email_info,
        ],$Messages::$mypage['mypage']['message']);
    }

    public function downloadfile(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $type_name = $request->input('type_name');
        $email_id = $request->input('email_id');
        $file_num = $request->input('file_num');

        $email_ori_file = "email_ori_file$file_num";
        $email_file = "email_file$file_num";

        $email_info = DB::table('emails')->select($email_ori_file, $email_file)->where('id', $email_id)->first();    //게시물 정보 추출

        $path = 'data/email';     //첨부물 저장 경로
        $down_file = public_path($path.'/'.$email_info->$email_file);

        return response()->download($down_file, $email_info->$email_ori_file);
    }

    public function modifysave(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //스마트 에디터 쿠키 때문에 일정 시간 지나면 글 못쓰게
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $email_subject = addslashes($request->input('email_subject'));
        $email_content = $request->input('email_content');

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)
        $path = 'data/email';     //첨부물 저장 경로

        $email_info = DB::table('emails')->where('id', $request->input('email_id'))->first();   //이메일 정보 읽기

        //DB 저장 배열 만들기
        $data = array(
            'email_subject' => $email_subject,
            'email_content' => $email_content,
        );

        for($i = 1; $i <= 2; $i++){
            $file_chk_tmp = 'file_chk'.$i;
            $file_chk = $request->input($file_chk_tmp); //수정,삭제,새로등록 체크 파악
            if($file_chk == 1){ //체크된 것들만 액션
                if($request->hasFile('email_file'.$i))
                {
                    $email_file[$i] = $request->file('email_file'.$i);
                    //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                    $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                    //첨부 파일 용량 예외처리
                    Validator::validate($request->all(), [
                        'email_file'.$i  => ['max:'.$max_size_mb]
                    ], [$upload_max_filesize."MB 까지만 저장 가능 합니다."]);

                    $attachment_result = CustomUtils::attachment_save($email_file[$i],$path); //위의 패스로 이미지 저장됨

                    $data['email_ori_file'.$i] = $attachment_result[2];  //배열에 추가 함
                    $data['email_file'.$i] = $attachment_result[1];  //배열에 추가 함

                    //기존 첨부 파일 처리
                    $email_file_tmp = 'email_file'.$i;
                    if($email_info->$email_file_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                        $img_path = $path.'/'.$email_info->$email_file_tmp;

                        if (file_exists($img_path)) {
                            @unlink($img_path); //이미지 삭제
                        }
                    }
                }else{  //첨부가 없음
                    //기존 첨부 파일 처리
                    $email_file_tmp = 'email_file'.$i;
                    if($email_info->$email_file_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                        $img_path = $path.'/'.$email_info->$email_file_tmp;

                        if (file_exists($img_path)) {
                            @unlink($img_path); //이미지 삭제
                        }
                    }

                    $data['email_ori_file'.$i] = "";  //배열에 추가 함
                    $data['email_file'.$i] = "";  //배열에 추가 함
                }
            }

            $update_result = DB::table('emails')->where('id', $request->input('email_id'))->limit(1)->update($data);
        }

        if($update_result = 1) return redirect()->route('adm.admemail.index')->with('alert_messages', $Messages::$email['e_ment']['e_modisave']);
        else return redirect()->route('adm.admemail.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
    }

    public function sendlist(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $email_id       = $request->input('id');
        $pageNum        = $request->input('page');
        $writeList      = 30;  //페이지당 글수
        $pageNumList    = 30; //블럭당 페이지수

        $page_control = CustomUtils::page_function('email_sends',$pageNum,$writeList,$pageNumList,'email_send','','','email_id',$email_id);

        $email_send_lists = DB::table('email_sends')->where('email_id',$email_id)->orderby('id', 'asc')->skip($page_control['startNum'])->take($writeList)->get();

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.email.emailsendlist',[
            'virtual_num'           => $page_control['virtual_num'],
            'email_send_lists'      => $email_send_lists,
            'pageNum'               => $page_control['pageNum'],
            'pageList'              => $pageList,
        ],$Messages::$mypage['mypage']['message']);
    }
}
