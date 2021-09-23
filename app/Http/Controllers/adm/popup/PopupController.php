<?php
#############################################################################
#
#		파일이름		:		PopupController.php
#		파일설명		:		팝업관리
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 03일
#		최종수정일		:		2021년 09월 03일
#
###########################################################################-->

namespace App\Http\Controllers\adm\popup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\popups;    //팝업 모델 정의

class PopupController extends Controller
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
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $pageNum     = $request->input('page');
        $writeList   = 10;  //10갯씩 뿌리기
        $pageNumList = 10; // 한 페이지당 표시될 글 갯수
        $type = 'popup';

        $page_control = CustomUtils::page_function('popups',$pageNum,$writeList,$pageNumList,$type,'','','','');

        $pop_infos = DB::table('popups')->orderby('id', 'DESC')->skip($page_control['startNum'])->take($writeList)->get();   //정보 읽기

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.popup.popuplist',[
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            "pop_infos"         => $pop_infos,
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
        ],$Messages::$mypage['mypage']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $path = 'data/popup';     //첨부물 저장 경로
        if (!is_dir($path)) {
            @mkdir($path, 0755);
            @chmod($path, 0755);
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $directory = "data/popup/editor";
        setcookie('directory', $directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        return view('adm.popup.popupcreate',[
        ],$Messages::$mypage['mypage']);
    }

    public function createsave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //스마트 에디터 시간 초과 파악
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $create_result = popups::create([
            'pop_disable_hours' => $request->input('pop_disable_hours'),
            'pop_start_time'    => $request->input('pop_start_time')." 00:00:00",
            'pop_end_time'      => $request->input('pop_end_time')." 23:59:59",
            'pop_left'          => $request->input('pop_left'),
            'pop_top'           => $request->input('pop_top'),
            'pop_width'         => $request->input('pop_width'),
            'pop_height'        => $request->input('pop_height'),
            'pop_subject'       => addslashes($request->input('pop_subject')),
            'pop_content'       => $request->input('pop_content'),
            'pop_display'       => $request->input('pop_display'),
        ])->exists();

        if($create_result) return redirect()->route('adm.popup.index')->with('alert_messages', $Messages::$popup['in_ok']);
        else return redirect()->route('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function modify(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id     = $request->input('num');
        $page   = $request->input('page');

        if($id == "")
        {
            return redirect('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $directory = "data/popup/editor";
        setcookie('directory', $directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $popup_info = DB::table('popups')->where('id', $id)->first();   //pop 가져 오기

        return view('adm.popup.popupmodify',[
            'page'          => $page,
            'popup_info'    => $popup_info,
        ],$Messages::$board['b_ment']);
    }

    public function modifysave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id     = $request->input('num');
        $page   = $request->input('page');

        if($id == "")
        {
            return redirect('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //스마트 에디터 시간 초과 파악
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        //DB 저장 배열 만들기
        $data = array(
            'pop_disable_hours' => $request->input('pop_disable_hours'),
            'pop_start_time'    => $request->input('pop_start_time')." 00:00:00",
            'pop_end_time'      => $request->input('pop_end_time')." 23:59:59",
            'pop_left'          => $request->input('pop_left'),
            'pop_top'           => $request->input('pop_top'),
            'pop_width'         => $request->input('pop_width'),
            'pop_height'        => $request->input('pop_height'),
            'pop_subject'       => addslashes($request->input('pop_subject')),
            'pop_content'       => $request->input('pop_content'),
            'pop_display'       => $request->input('pop_display'),
        );

        //$update_result = DB::table('popups')->where('id', $id)->limit(1)->update($data);
        $update_result = Popups::find($id)->update($data);

        if($update_result) return redirect()->route('adm.popup.index','&page='.$page)->with('alert_messages', $Messages::$popup['up_ok']);
        else return redirect('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function destroy(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id     = $request->input('num');

        if($id == "")
        {
            return redirect('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $path = 'data/popup';     //첨부물 저장 경로
        $editor_path = $path."/editor";     //스마트 에디터 첨부 저장 경로

        $pop_info = DB::table('popups')->where('id', $id)->first();   //팝업 정보

        //스마트 에디터 내용에 첨부된 이미지 색제
        $editor_img_del = CustomUtils::editor_img_del($pop_info->pop_content, $editor_path);

        $delete_result = DB::table('popups')->where('id',$id)->delete();   //row 삭제

        return redirect()->route('adm.popup.index')->with('alert_messages', $Messages::$popup['del_ok']);
    }
}
