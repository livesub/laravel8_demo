<?php
#############################################################################
#
#		파일이름		:		InfosaveController.php
#		파일설명		:		회원 정보 수정
#		저작권			:		저작권은 제작자 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;  //체크
use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Str;     //각종 함수(str_random)
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\File;

class InfosaveController extends Controller
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
        //
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
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $user_name = trim($request->get('user_name'));
        $user_phone = trim($request->get('user_phone'));
        $user_id = Auth::user()->user_id;


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
                    return redirect()->route('main.index')->with('alert_messages', $Messages::$file_chk['file_chk']['message']['file_false']);
                    exit;
                }else{
                    //서버에 올라간 파일을 썸네일 만든다.
                    $thumb_width = config('app.thumb_width');
                    $thumb_height = config('app.thumb_height');
                    $is_create = false;
                    $thumb_name = CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                /* DB:: (엘로퀀트)형식으로 update시 변경 사항 없이 update 시 result 값이 0으로 리턴되어 값을 잡을수 없음
                $result_up = DB::table('users')
                ->where('user_id', $user_id)
                ->update([
                    'user_name' => $user_name,
                    'user_phone' => $user_phone,
                    'user_imagepath' => $attachment_result[1],
                    'user_ori_imagepath' => $attachment_result[2]
                ]);
                */

                $user = User::whereUser_id($user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
                $user->user_name = $user_name;
                $user->user_phone = $user_phone;
                $user->user_imagepath = $attachment_result[1];
                $user->user_ori_imagepath = $attachment_result[2];
                $user->user_thumb_name = $thumb_name;
                $result_up = $user->save();

                if(!$result_up)
                {
                    return redirect()->route('mypage.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);
                    exit;
                }else{

                    //기존 이미지가 있는지 체크
                    if(Auth::user()->user_imagepath != "")
                    {
                        //기존에 이미 이미지가 있는 상태임
                        $deleted = File::delete (public_path ('/data/member/'.Auth::user()->user_imagepath));
        /*
                        //이미지가 지워졌울때 계속 에러 표현 됨 일단 맏자!!!
                        if(!$deleted)
                        {
                            return redirect()->route('mypage.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);
                            exit;
                        }
        */
                    }

                    //기존 썸네일 이미지가 있는지 체크
                    if(Auth::user()->user_thumb_name != "")
                    {
                        //기존에 이미 썸네일 이미지가 있는 상태임
                        $deleted = File::delete (public_path ('/data/member/'.Auth::user()->user_thumb_name));
                    }

                    return redirect()->route('mypage.index')->with('alert_messages', $Messages::$mypage['mypage']['message']['my_change']);
                    exit;
                }
            }
        }else{
            //첨부가 없을때
            /* DB:: (엘로퀀트)형식으로 update시 변경 사항 없이 update 시 result 값이 0으로 리턴되어 값을 잡을수 없음
            $result_up = DB::table('users') -> where('user_id', $user_id)
                ->update([
                    'user_name' => $user_name,
                    'user_phone' => $user_phone
                ]);
            dd($result_up);
            */

            $user = User::whereUser_id($user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
            $user->user_name = $user_name;
            $user->user_phone = $user_phone;
            $result_up = $user->save();

            if(!$result_up)
            {
                return redirect()->route('mypage.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);
                exit;
            }else{
                return redirect()->route('mypage.index')->with('alert_messages', $Messages::$mypage['mypage']['message']['my_change']);
                exit;
            }
        }
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
