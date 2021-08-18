<?php

namespace App\Http\Controllers\adm\admemail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크
use App\Models\emails;    //이메일 내용 모델 정의

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

    public function index()
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        return view('adm.email.emaillist',[
/*
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            "cate_infos"        => $cate_infos,
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
*/
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

        $pageNum     = $request->input('page');
        $writeList   = 10;  //페이지당 글수
        $pageNumList = 10; //블럭당 페이지수
        dd("내일~~");
        $page_control = CustomUtils::page_function('emails',$pageNum,$writeList,$pageNumList,'email','','','','');

//        $email_lists = DB::select("select * from board_datas_tables where bm_tb_name = '{$tb_name}' {$cate_sql} {$search_sql} order by bdt_grp desc, bdt_sort asc limit {$page_control['startNum']} , {$writeList}");

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];



        return view('adm.email.emailcreate',[
            'virtual_num'               => $page_control['virtual_num'],
            'totalCount'                => $page_control['totalCount'],
            'pageNum'                   => $page_control['pageNum'],
            //'pageList'                  => $pageList,
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

        $email_subject = addslashes($request->input('email_subject'));
        $email_content = $request->input('email_content');


        $file_cnt = 2;    //설정시 사용할 첨부 갯수
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
