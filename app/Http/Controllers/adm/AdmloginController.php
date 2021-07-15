<?php
#############################################################################
#
#		파일이름		:		AdmloginController.php
#		파일설명		:		관리자페이지 로그인
#		저작권			:		저작권은 제작자 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Http\Controllers\adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Validator;  //체크
use Illuminate\Support\Facades\Auth;    //인증

class AdmloginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //로그인 안된 상태에선 이페이지 못열게
        //$this->middleware('auth', ['except' => 'destroy']);
        $this->middleware('guest');
    }

    public function index()
    {
        //
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        return view('adm.admlogin',$Messages::$adm_log_ment['admlogin']['message']);
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

        $user_id = $request->get('user_id');
        $user_pw = $request->get('user_pw');

        Validator::validate($request->all(), [
            'user_id'  => ['required', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/', 'max:200'],
            'user_pw'  => ['required', 'string', 'min:6', 'max:16'],
        ], $Messages::$login_Validator['login_Validator']['message']);


        $credentials = [
            'user_id' => trim($user_id),
            'password' => $user_pw,
            'user_level' => 3,
        ];

        if (!Auth::attempt($credentials))
        {
            return redirect()->route('adm.login.index')->with('alert_messages', $Messages::$adm_login_chk['login_chk']['message']['login_chk']);
            exit;
        }

        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$adm_login_chk['login_chk']['message']['login_ok']);
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
