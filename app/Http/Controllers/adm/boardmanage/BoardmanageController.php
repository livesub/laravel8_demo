<?php
#############################################################################
#
#		파일이름		:		BoardmanageController.php
#		파일설명		:		관리자페이지 게시판 설정
#		저작권			:		저작권은 제작자 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 16일
#		최종수정일		:		2021년 07월 16일
#
###########################################################################-->

namespace App\Http\Controllers\adm\boardmanage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Models\User;    //모델 정의(사용자 테이블)
use App\Models\boardmanager;    //모델 정의(게시판 관리 테이블)
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;


class BoardmanageController extends Controller
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

        //select 쿼리
        $b_lists = DB::table('boardmanagers')->orderBy('id', 'desc')->get();

        return view('adm.boardmanage.boardmanage', [
            'b_lists'=>$b_lists
        ],$Messages::$boardmanage['bm']['message']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $bm_tb_name       = $request->input('bm_tb_name');
        $bm_tb_subject    = $request->input('bm_tb_subject');
        $bm_file_num      = $request->input('bm_file_num');

        $create_result = boardmanager::create([
            'bm_tb_name' => $bm_tb_name,
            'bm_tb_subject' => $bm_tb_subject,
            'bm_file_num' => $bm_file_num,
        ])->exists(); //저장,실패 결과 값만 받아 오기 위해  exists() 를 씀

        if($create_result = 1) return redirect()->route('adm.boardmanage.index')->with('alert_messages', $Messages::$boardmanage['bm']['message']['bmm_tb_add_ok']);
        else return redirect()->route('adm.boardmanage.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
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
        $num       = $request->input('num');
        $bm_coment_type       = $request->input('bm_coment_type');
        if($bm_coment_type == null) $bm_coment_type = 0;

        $bm_secret_type       = $request->input('bm_secret_type');
        if($bm_secret_type == null) $bm_secret_type = 0;

        $b_set = boardmanager::whereid($num)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $b_set->bm_tb_subject = $request->input('bm_tb_subject');
        $b_set->bm_file_num = $request->input('bm_file_num');
        $b_set->bm_resize_max_size = $request->input('bm_resize_max_size');
        $b_set->bm_resize_file_num = $request->input('bm_resize_file_num');
        $b_set->bm_resize_width_file = $request->input('bm_resize_width_file');
        $b_set->bm_resize_height_file = $request->input('bm_resize_height_file');
        $b_set->bm_list_chk = $request->input('bm_list_chk');
        $b_set->bm_write_chk = $request->input('bm_write_chk');
        $b_set->bm_view_chk = $request->input('bm_view_chk');
        $b_set->bm_modify_chk = $request->input('bm_modify_chk');
        $b_set->bm_delete_chk = $request->input('bm_delete_chk');
        $b_set->bm_reply_chk = $request->input('bm_reply_chk');
        $b_set->bm_comment_chk = $request->input('bm_comment_chk');
        $b_set->bm_category_key = $request->input('bm_category_key');
        $b_set->bm_category_ment = $request->input('bm_category_ment');
        $b_set->bm_coment_type = $bm_coment_type;
        $b_set->bm_secret_type = $bm_secret_type;
        $b_set->bm_page_num = $request->input('bm_page_num');
        $b_set->bm_subject_len = $request->input('bm_subject_len');
        $b_set->bm_record_num = $request->input('bm_record_num');
        $b_set->bm_page_num = $request->input('bm_page_num');
        $result_up = $b_set->save();

        if(!$result_up)
        {
            return redirect()->route('adm.boardmanage.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);
            exit;
        }else{
            return redirect()->route('adm.boardmanage.index')->with('alert_messages', $Messages::$boardmanage['bm']['message']['bmm_tb_up_ok']);
            exit;
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

        $num        = $request->input('num');

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $board_info = DB::table('boardmanagers')->where('id', $num)->first();

        return view('adm.boardmanage.boardmanageview',["board_info" => $board_info],$Messages::$mypage['mypage']['message']);
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
