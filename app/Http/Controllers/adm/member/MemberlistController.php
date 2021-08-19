<?php
#############################################################################
#
#		파일이름		:		MemberlistController.php
#		파일설명		:		관리자페이지 - 회원 리스트,수정,삭제,비번 수정
#		저작권			:		저작권은 제작자 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Http\Controllers\adm\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Models\User;    //모델 정의
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;     //각종 함수(str_random)
use Validator;  //체크
use Illuminate\Support\Facades\Hash; //비밀번호 함수
use Illuminate\Support\Facades\File;

class MemberlistController extends Controller
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
        $writeList   = 10;  //10갯씩 뿌리기
        $pageNumList = 10; // 한 페이지당 표시될 글 갯수
        $type = 'member';

        $page_control = CustomUtils::page_function('users',$pageNum,$writeList,$pageNumList,$type,'','','','');
        $members = DB::table('users')->orderBy('id', 'desc')->skip($page_control['startNum'])->take($writeList)->get();

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.memberlist', [
            'virtual_num'=>$page_control['virtual_num'],
            'totalCount'=>$page_control['totalCount'],
            'members'=>$members,
            'pageNum'=>$page_control['pageNum'],
            'pageList'=>$pageList
        ]); // 요청된 정보 처리 후 결과 되돌려줌
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mode       = $request->input('mode');
        $num        = $request->input('num');

        if($mode == "regi"){
            //등록일때
            $user_id = trim($request->get('user_id'));
            $user_name = trim($request->get('user_name'));
            $user_pw = trim($request->get('user_pw'));
            $user_pw_confirmation = trim($request->get('user_pw_confirmation'));
            //$user_email = $request->get('user_email');
            $user_phone = trim($request->get('user_phone'));
            $user_confirm_code = str::random(60);  //사용자 이메일 확인을 위해서..


            //trans('messages.join_Validator')) class 컨트롤러에서 표현 할때
            //예외처리
            Validator::validate($request->all(), [
                'user_id'  => ['required', 'string', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/', 'max:200', 'unique:users'],
                'user_name'  => ['required', 'string'],
                'user_pw'  => ['required', 'string', 'min:6', 'max:16', 'confirmed'],
                'user_pw_confirmation'  => ['required', 'string', 'min:6', 'max:16', 'same:user_pw'],
                'user_phone'  => ['required', 'max:20']
            ], $Messages::$validate['join']['message']);


            if($request->hasFile('user_imagepath'))
            {
                //첨부 파일이 있을때
                $user_imagepath = $request->file('user_imagepath');
                foreach ($user_imagepath as $key => $file)
                {
                    //예외처리
                    Validator::validate($request->all(), [
                        'user_imagepath.*'  => ['max:10240', 'mimes:jpeg,jpg,gif']
                    ], $Messages::$file_chk['file_chk']['message']);

                    $path = 'data/member';     //이미지 저장 경로
                    $attachment_result = CustomUtils::attachment_save($file,$path);

                    if(!$attachment_result[0])
                    {
                        return redirect()->route('adm.member.show')->with('alert_messages', $Messages::$file_chk['file_chk']['message']['file_false']);
                        exit;
                    }else{
                        //서버에 올라간 파일을 썸네일 만든다.
                        $thumb_width = config('app.thumb_width');
                        $thumb_height = config('app.thumb_height');
                        $is_create = false;
                        $thumb_name = CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }
                }
            }else{
                //이미지 없을때 처리
                $attachment_result[1] = '';
                $attachment_result[2] = '';
                $thumb_name = '';
            }

            //User::insert 일때는 created_at,updated_at 값이 자동으로 들어 가지 않는다.
            $create_result = User::create([
                'user_id' => $user_id,
                'user_name' => $user_name,
                'password' => Hash::make($user_pw),
                'user_phone' => $user_phone,
                'user_confirm_code' => $user_confirm_code,
                'user_imagepath' => $attachment_result[1],
                'user_ori_imagepath' => $attachment_result[2],
                'user_thumb_name' => $thumb_name,

            ])->exists(); //저장,실패 결과 값만 받아 오기 위해  exists() 를 씀

            $data = array(
                'user_name' => $user_name,
                'user_confirm_code' => $user_confirm_code,
                'name_welcome' => $Messages::$email_certificate['email_certificate']['message']['name_welcome'],
                'join_open' => $Messages::$email_certificate['email_certificate']['message']['join_open'],
            );

            $subject = sprintf('[%s] '.$Messages::$join_confirm_ment['confirm']['message']['join_confirm'], $user_name);

            //이메일 함수 이용 발송
            $email_send_value = CustomUtils::email_send("auth.confirm_email",$user_name, $user_id, $subject, $data);

            if(!$email_send_value)
            {
                //이메일 발송 실패 시에 뭘 할건지 나중에 생각해야함
            }

            if($create_result = 1) return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$join_confirm_ment['confirm']['message']['adm_join_success']);
            else return redirect()->route('adm.member.create')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
        }else{
            //수정일때
            Validator::validate($request->all(), [
                'user_name'  => ['required', 'string']
            ], $Messages::$validate['join']['message']);

            $user_info = DB::table('users')->select('user_id', 'user_imagepath', 'user_thumb_name')->where('id', $num)->first();

            $user_name = trim($request->get('user_name'));
            $user_phone = trim($request->get('user_phone'));
            $user_level = $request->get('user_level');

            $user_id = $user_info->user_id;

            if($request->hasFile('user_imagepath'))
            {
                //첨부 파일이 있을때
                $user_imagepath = $request->file('user_imagepath');

                foreach ($user_imagepath as $key => $file)
                {
                    //예외처리
                    Validator::validate($request->all(), [
                        'user_imagepath.*'  => ['max:10240', 'mimes:jpeg,jpg,gif']
                    ], $Messages::$file_chk['file_chk']['message']);

                    $path = 'data/member';     //이미지 저장 경로
                    $attachment_result = CustomUtils::attachment_save($file,$path);

                    if(!$attachment_result[0])
                    {
                        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$file_chk['file_chk']['message']['file_false']);
                        exit;
                    }else{
                        //서버에 올라간 파일을 썸네일 만든다.
                        $thumb_width = config('app.thumb_width');
                        $thumb_height = config('app.thumb_height');
                        $is_create = false;
                        $thumb_name = CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $user = User::whereUser_id($user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
                    $user->user_name = $user_name;
                    $user->user_phone = $user_phone;
                    $user->user_level = $user_level;
                    $user->user_imagepath = $attachment_result[1];
                    $user->user_ori_imagepath = $attachment_result[2];
                    $user->user_thumb_name = $thumb_name;
                    $result_up = $user->save();

                    if(!$result_up)
                    {
                        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);
                        exit;
                    }else{

                        //기존 이미지가 있는지 체크
                        if($user_info->user_imagepath != "")
                        {
                            //기존에 이미 이미지가 있는 상태임
                            $deleted = File::delete (public_path ('/data/member/'.$user_info->user_imagepath));
                        }

                        //기존 썸네일 이미지가 있는지 체크
                        if($user_info->user_thumb_name != "")
                        {
                            //기존에 이미 썸네일 이미지가 있는 상태임
                            $deleted = File::delete (public_path ('/data/member/'.$user_info->user_thumb_name));
                        }

                        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$mypage['mypage']['message']['my_change']);
                        exit;
                    }
                }
            }else{
                //첨부가 없을때
                $user = User::whereUser_id($user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
                $user->user_name = $user_name;
                $user->user_phone = $user_phone;
                $result_up = $user->save();

                if(!$result_up)
                {
                    return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);
                    exit;
                }else{
                    return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$mypage['mypage']['message']['my_change']);
                    exit;
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mode       = $request->input('mode');
        $num        = $request->input('num');

        if($mode == "regi"){
            //등록
            $select_disp = CustomUtils::select_box("user_level","회원@@관리자","10@@".config('app.ADMIN_LEVEL'), "");

            return view('adm.memberregi',[
                'title_ment'            => '등록',
                'mode'                  => 'regi',
                'num'                   => '',
                'user_id'               => '',
                'user_name'             => '',
                'user_pw'               => '',
                'user_pw_confirmation'  => '',
                'user_phone'            => '',
                'user_imagepath'        => '',
                'select_disp'           => $select_disp,
            ],$Messages::$mypage['mypage']['message']);
        }else{
            //수정
            //회원 정보를 찾아 놓음
            $user_info = DB::table('users')->select('id', 'user_id', 'user_name', 'user_phone', 'user_thumb_name', 'user_ori_imagepath', 'user_level', 'user_type','created_at')->where('id', $num)->first();
            $select_disp = CustomUtils::select_box("user_level","회원@@관리자","10@@".config('app.ADMIN_LEVEL'), "$user_info->user_level");

            if($user_info->user_type == "Y") $user_status = "탈퇴";
            else $user_status = "가입";

            return view('adm.memberregi',[
                'title_ment'            => '수정',
                'mode'                  => 'modi',
                'num'                   => $user_info->id,
                "type"                  => 'member_'.$user_info->id,   //원하는 첨부파일 경로와 순번 값을 함쳐서 보낸다.
                'user_id'               => $user_info->user_id,
                'user_name'             => $user_info->user_name,
                'user_pw'               => '',
                'user_pw_confirmation'  => '',
                'user_phone'            => $user_info->user_phone,
                'created_at'            => $user_info->created_at,
                'user_imagepath'        => $user_info->user_thumb_name,
                'user_ori_imagepath'    => $user_info->user_ori_imagepath,
                'select_disp'           => $select_disp,
                'user_status'           => $user_status,

            ],$Messages::$mypage['mypage']['message']);
        }
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

    public function pw_change(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $user_pw = trim($request->get('user_pw'));
        $user_pw_confirmation = trim($request->get('user_pw_confirmation'));
        $num        = $request->get('num');

        $validator = Validator::make($request->all(), [
            'user_pw'  => ['required', 'string', 'min:6', 'max:16', 'confirmed'],
            'user_pw_confirmation'  => ['required', 'string', 'min:6', 'max:16', 'same:user_pw'],
        ], $Messages::$mypage['validate']['message']);


        $user_info = DB::table('users')->select('user_id', 'password')->where('id', $num)->first();
/*
//새로 들어온 비밀 번호가 현재 비밀 번호와 같으면 튕기게 하기
의도는 전 비밀 번호와 현 비밀 번호가 같으면 튕기게 하려 했으나
Auth::attempt($credentials) 응 통해 비교 했다가 비교 했던 아이디로 로그인 되어 버림
현재로선 그냥 비번 바꾸는 걸로...(21.07.14)

        $credentials = [
            'user_id' => $user_info->user_id,
            'password' => $user_pw,
        ];

        if (Auth::attempt($credentials))
        {
            //기존 비밀번호와 같을때 에러 처리
            return response()->json(['status_ment' => $Messages::$mypage['validate']['message']['pwsame_false'],'status' => 'false'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }
*/

        $result_up = DB::table('users')->where('user_id', $user_info->user_id)->update(['password' => Hash::make($user_pw)]);

        if(!$result_up)
        {
            return response()->json(['status_ment' => $Messages::$fatal_fail_ment['fatal_fail']['message']['error'],'status' => 'false'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }else{
            return response()->json(['status_ment' => $Messages::$mypage['validate']['message']['admpwchange_ok'],'status' => 'true'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }
    }


    public function imgdel(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $num        = $request->input('num');

        $user_info = DB::table('users')->select('user_id', 'user_imagepath', 'user_thumb_name')->where('id', $num)->first();

        $img = "";
        $img_thumb = "";

        //기존 이미지가 있는지 체크
        if($user_info->user_imagepath != "")
        {
            //기존에 이미 이미지가 있는 상태임
            $deleted = File::delete (public_path ('/data/member/'.$user_info->user_imagepath));
            if($deleted) $img = 'Y';
        }

        //기존 썸네일 이미지가 있는지 체크
        if($user_info->user_thumb_name != "")
        {
            //기존에 이미 썸네일 이미지가 있는 상태임
            $deleted = File::delete (public_path ('/data/member/'.$user_info->user_thumb_name));
            if($deleted) $img_thumb = 'Y';
        }

        $user = User::whereUser_id($user_info->user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $user->user_imagepath = "";
        $user->user_ori_imagepath = "";
        $user->user_thumb_name = "";
        $result_up = $user->save();

        if($img == "Y" && $img_thumb == "Y" && $result_up){
            return response()->json(['status_ment' => $Messages::$mypage['validate']['message']['img_del_ok'],'status' => 'true'], 200, [], JSON_PRETTY_PRINT);
        }else{
            return response()->json(['status_ment' => $Messages::$fatal_fail_ment['fatal_fail']['message']['error'],'status' => 'false'], 200, [], JSON_PRETTY_PRINT);
        }
    }

    public function member_out(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            //탈퇴된 사람은 살리고, 안된 사람은 탈퇴 시기기 위해 회원 정보 불러옴
            $user_info = DB::table('users')->select('user_type')->where('id', $request->input('chk_id')[$i])->first();
            if($user_info->user_type == "Y") $type_change = "N";
            else $type_change = "Y";

            $user = User::whereid($request->input('chk_id')[$i])->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
            $user->user_type = $type_change;
            $result_up = $user->save();
        }
        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$adm_mem_chk['mem_chk']['message']['out_ok']);
    }
}
