<?php
#############################################################################
#
#		파일이름		:		MypageController.php
#		파일설명		:		비번 변경
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\Hash; //비밀번호 함수

class MypageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $data = $Messages::$mypage['mypage'];

        $array_make = array(
            "type" => 'member_'.Auth::user()->id,   //원하는 첨부파일 경로와 순번 값을 함쳐서 보낸다.
            "user_id" => Auth::user()->user_id,
            "user_name" => Auth::user()->user_name,
            "user_phone" => Auth::user()->user_phone,
            "user_imagepath" => Auth::user()->user_imagepath,
            "user_ori_imagepath" => Auth::user()->user_ori_imagepath,
            "user_thumb_name" => Auth::user()->user_thumb_name,
            "created_at" => Auth::user()->created_at->format('Y-m-d H:i:s')
        );

        $data = array_merge($data, $array_make);

        return view('member.mypage',$data);
    }

    public function pw_change(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $user_pw = trim($request->get('user_pw'));
        $user_pw_confirmation = trim($request->get('user_pw_confirmation'));

        Validator::validate($request->all(), [
            'user_pw'  => ['required', 'string', 'min:6', 'max:16', 'confirmed'],
            'user_pw_confirmation'  => ['required', 'string', 'min:6', 'max:16', 'same:user_pw'],
        ], $Messages::$mypage['validate']);

        //새로 들어온 비밀 번호가 현재 비밀 번호와 같으면 튕기게 하기
        $user_id = Auth::user()->user_id;
        $credentials = [
            'user_id' => $user_id,
            'password' => $user_pw,
        ];

        if (Auth::attempt($credentials))
        {
            //기존 비밀번호와 같을때 에러 처리
            return response()->json(['status_ment' => $Messages::$mypage['validate']['pwsame_false'],'status' => 'false'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }

        $result_up = DB::table('users')->where('user_id', $user_id)->update(['password' => Hash::make($user_pw)]);

        if(!$result_up)
        {
            return response()->json(['status_ment' => $Messages::$fatal_fail_ment['fatal_fail']['error'],'status' => 'false'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }else{
            auth()->logout();
            return response()->json(['status_ment' => $Messages::$mypage['validate']['pwchange_ok'],'status' => 'true'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }
    }

    //탈퇴 처리
    public function withdraw(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        $user_id = Auth::user()->user_id;

        $result_up = DB::table('users')->where('user_id', $user_id)->update(['user_type' => 'Y']);

        $user_info = User::whereUser_id($user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $user_info->user_type = $user_info->user_type = 'Y';
        $result_up = $user_info->save();

        if(!$result_up)
        {
            return redirect()->route('mypage.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
            exit;
        }else{
            auth()->logout();
            return redirect()->route('main.index')->with('alert_messages', $Messages::$mypage['mypage']['withdraw_ok']);
            exit;
        }
    }
}
