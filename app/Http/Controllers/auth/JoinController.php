<?php
#############################################################################
#
#		파일이름		:		JoinController.php
#		파일설명		:		회원가입
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;  //체크
use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Facades\Hash; //비밀번호 함수
use Illuminate\Support\Str;     //각종 함수(str_random)
use Illuminate\Support\Facades\Mail;    //메일 class
use Illuminate\Support\Facades\DB;

class JoinController extends Controller
{
    public function __construct()
    {
        //로그인 된 상태에선 이 페이지 못열게
        $this->middleware('guest', ['except' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        return view('auth.join',$Messages::$blade_ment['join']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**************************************************************************/
     /* $user_pw 을 사용 하면 로그인이 되지 않으므로 칼럼명을 password 로 바꾼다 */
     /**************************************************************************/
     public function store(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

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
        ], $Messages::$validate['join']);

/******************************************************* */
/* model 형식으로 DB 처리 프로그램 할때 사용               */
/******************************************************* */
        //같은 아이디가 있는지 파악(validator user_id 에서 unique:users 하기에 같은 아이디 찾기 프로그램은 필요 없다.)
        /*
        $count_result = User::where('user_id', '=', $user_id) -> count();
        if($count_result <> 0) {
            return response()->json(['status' => 'overlap_user_id'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }
        */

        //User::insert 일때는 created_at,updated_at 값이 자동으로 들어 가지 않는다.
        $create_result = User::create([
            'user_id' => $user_id,
            'user_name' => $user_name,
            'password' => Hash::make($user_pw),
            'user_phone' => $user_phone,
            'user_confirm_code' => $user_confirm_code,
        ])->exists(); //저장,실패 결과 값만 받아 오기 위해  exists() 를 씀
/*
        $tmp_time = date("Y-m-d H:i:s", time());
        DB::insert('insert into users (user_id, user_name, password, user_phone, user_confirm_code, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ? )', [$user_id, $user_name, Hash::make($user_pw), $user_phone, $user_confirm_code, $tmp_time, $tmp_time]);
*/

        $data = array(
            'user_name' => $user_name,
            'user_confirm_code' => $user_confirm_code,
            'name_welcome' => $Messages::$email_certificate['email_certificate']['name_welcome'],
            'join_open' => $Messages::$email_certificate['email_certificate']['join_open'],
        );

        $subject = sprintf('[%s] '.$Messages::$join_confirm_ment['confirm']['join_confirm'], $user_name);


        //이메일 함수 이용 발송
        $email_send_value = CustomUtils::email_send("auth.confirm_email",$user_name, $user_id, $subject, $data);

        if(!$email_send_value)
        {
            //이메일 발송 실패 시에 뭘 할건지 나중에 생각해야함
        }

        if($create_result = 1) return redirect()->route('main.index')->with('alert_messages', $Messages::$join_confirm_ment['confirm']['join_success']);
        else return redirect()->route('main.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해


        /******************************************************* */
        /* model 에 정의 하지 않고 DB 처리 프로그램 할때 사용       */
        /******************************************************* */
/*
//예제1)
        $count_result = DB::table('users') -> select(DB::raw('count(*) as user_count')) -> where('user_name', '=', $user_name) -> get();
        if($count_result[0]->user_count <> 0) {
            return response()->json(['status' => 'overlap_user_name'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }

        $in_result = DB::table('users')->insert([
            'role_id'   => 2,
            'user_name'  => $user_name,    //아이디
            'password'  => Hash::make($password),
            'name'      => $name,    //이름
            'phone'     => $phone,
            'email'     => $email
        ]);

        if($in_result = 1) $status = true;
        else $status = false;

        return response()->json(['status' => $status], 200, [], JSON_PRETTY_PRINT);
*/


/*
//예제2)
        $user = new User([
            'role_id'   => 2,
            'user_name'  => $user_name,    //아이디
            'password'  => Hash::make($password),
            'name'      => $name,    //이름
            'phone'     => $phone,$status = false;
            'email'     => $email
        ]);

        $result = $user->save();

        if(!$result) $status = false;
        else $status = true;

        return response()->json(['status' => $status], 200, [], JSON_PRETTY_PRINT);
*/
    }

    /* 인증 메일을 통한 인증 작업 */
    public function confirm($code)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $user = User::whereUserConfirmCode($code)->first();

        if (!$user) {
            return redirect()->route('join.create')->with('alert_messages', $Messages::$email_certificate['email_certificate']['email_confirm_fail']);
            exit;
        }

        $user->user_activated = 1;
        $user->user_confirm_code = null;
        $user->save();

        return redirect()->route('join.create')->with('alert_messages', $Messages::$email_certificate['email_certificate']['email_confirm_success']);
        exit;
    }
}
