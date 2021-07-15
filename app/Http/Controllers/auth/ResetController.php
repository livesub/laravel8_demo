<?php
#############################################################################
#
#		파일이름		:		ResetController.php
#		파일설명		:		비번 변경
#		저작권			:		저작권은 제작자 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;  //체크
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\Hash; //비밀번호 함수

class ResetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index($token = null)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $data = $Messages::$pwreset['pwreset']['message'];
        $data = array_merge($data, array("token"=>$token));

        return view('auth.pwreset', $data);
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

        $user_id = trim($request->get('user_id'));
        $user_pw = $request->get('user_pw');
        $user_pw_confirmation = $request->get('user_pw_confirmation');
        $pw_token = $request->get('pw_token');

        //예외처리
        Validator::validate($request->all(), [
            'user_id'  => ['required', 'string', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/', 'max:200', 'exists:users'],
            'user_pw'  => ['required', 'string', 'min:6', 'max:16', 'confirmed'],
            'user_pw_confirmation'  => ['required', 'string', 'min:6', 'max:16', 'same:user_pw'],
        ], $Messages::$pwreset['pwreset_Validator']['message']);

        $users_status = DB::table('password_resets')->where([
            ['pw_user_id', '=', $user_id],
            ['pw_token', '=', $pw_token],
        ])->first();

        if(!$users_status){
            return back()->with('alert_messages', $Messages::$pwreset['pwreset_false']['message']['pwreset_false']);
            exit;
        }

        //새로 들어온 비밀 번호가 현재 비밀 번호와 같으면 튕기게 하기
        $credentials = [
            'user_id' => $user_id,
            'password' => $user_pw,
        ];

        if (Auth::attempt($credentials))
        {
            auth()->logout();
            //기존 비밀번호와 같을때 에러 처리
            return back()->with('alert_messages', $Messages::$pwreset['pwreset_false']['message']['pwsame_false']);
            exit;
        }

        $result_up = DB::table('users')->where('user_id', $user_id)->update(['password' => Hash::make($user_pw)]);

        if(!$result_up)
        {
            return back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
            exit;
        }

        $result = DB::table('password_resets')->wherepwToken($pw_token)->delete();

        return redirect()->route('login.index')->with('alert_messages', $Messages::$pwreset['pwreset_ok']['message']['pwreset_ok']);
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
