<?php
#############################################################################
#
#		파일이름		:		Pwchange.php
#		파일설명		:		비밀번호 변경
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
use Carbon\Carbon;
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Str;     //각종 함수(str_random)
use Illuminate\Support\Facades\DB;


class PwchangeController extends Controller
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

    public function index()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        return view('auth.pwchange',$Messages::$pwchange['pwchange']['message']);
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

        $pw_user_id = $request->get('user_id');

        Validator::validate($request->all(), [
            'user_id'  => ['required', 'string', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/', 'max:200', 'exists:users'],
        ], $Messages::$pwchange['pwchange']['message']);

        //table를 검색 해서 아이디와 이름을 가져 온다
        $user = DB::table('users')->where('user_id', $pw_user_id)->first();
        $user_id = $user->user_id;
        $user_name = $user->user_name;

        $pw_token = Str::random(64);

        $insert_result = DB::table('password_resets')->insert([
            'pw_user_id' => $pw_user_id,
            'pw_token' => $pw_token,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);

        //->exists(); //저장,실패 결과 값만 받아 오기 위해  exists() 를 씀
        $data = array(
            'pw_token' => $pw_token,
            'email_body' => $Messages::$pwchange['pwchange']['message']['email_body'],
        );

        $subject = sprintf('[%s] '.$Messages::$pwchange['pwchange']['message']['email_change'], $user_name);
        //이메일 함수 이용 발송
        $email_send_value = CustomUtils::email_send("auth.pwchange_email",$user_name, $user_id, $subject, $data);

        if(!$email_send_value)
        {
            //이메일 발송 실패 시에 뭘 할건지 나중에 생각해야함
        }

        if($insert_result) return redirect()->route('login.index')->with('alert_messages', $Messages::$pwchange['pwchange']['message']['email_send']);
        else return redirect()->route('login.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
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
