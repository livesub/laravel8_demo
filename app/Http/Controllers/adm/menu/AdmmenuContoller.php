<?php
#############################################################################
#
#		파일이름		:		AdmmenuController.php
#		파일설명		:		관리자 메뉴 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers\adm\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크
use App\Models\menus;    //카테고리 모델 정의

class AdmmenuContoller extends Controller
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
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $pageNum     = $request->input('page');
        $writeList   = 20;  //10갯씩 뿌리기
        $pageNumList = 20; // 한 페이지당 표시될 글 갯수
        $type = 'menu';

        $page_control = CustomUtils::page_function('menuses',$pageNum,$writeList,$pageNumList,$type,'','','','');
        $menu_infos = DB::table('menuses')->orderby('menu_id', 'ASC')->skip($page_control['startNum'])->take($writeList)->get();   //정보 읽기

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.menu.menulist',[
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            "menu_infos"        => $menu_infos,
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //코드 자동 생성
        $menu_id        = $request->input('menu_id');
        $len            = strlen($menu_id);

        if ($len == 6){
            return redirect()->route('adm.menu.index')->with('alert_messages', $Messages::$menu['insert']['menu_no']);
            exit;
        }

        $path = 'data/menu';     //첨부물 저장 경로
        if (!is_dir($path)) {
            @mkdir($path, 0755);
            @chmod($path, 0755);
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $edit_directory = "data/menu/editor";
        setcookie('directory', $edit_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $len2 = $len + 1;

        $max_menu_id = DB::select(" select MAX(SUBSTRING(menu_id,$len2,2)) as max_subid from menuses where SUBSTRING(menu_id,1,$len) = '$menu_id' ");
        $subid = base_convert($max_menu_id[0]->max_subid, 36, 10);
        $subid += 36;

        if ($subid >= 36 * 36)
        {
        // 빈상태로
            $subid = "  ";
        }

        $subid = base_convert($subid, 10, 36);
        $subid = substr("00" . $subid, -2);
        $subid = $menu_id . $subid;

        $sublen = strlen($subid);

        return view('adm.menu.menucreate',[
            'mk_menu_id'          => $subid,
        ]);
    }

    public function createsave(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $menu_id            = $request->input('menu_id');
        $menu_name_en       = $request->input('menu_name_en');
        $menu_name_kr       = $request->input('menu_name_kr');
        $menu_display       = $request->input('menu_display');
        $menu_rank          = $request->input('menu_rank');
        $menu_page_type     = $request->input('menu_page_type');
        $menu_content       = $request->input('menu_content');

        if($menu_rank == "") $menu_rank = 0;

        if($menu_id == ""){
            return redirect('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //스마트 에디터 시간 초과 파악
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        Validator::validate($request->all(), [
            'menu_id'       => ['required', 'unique:menuses', 'max:6'],
            'menu_name_en'  => ['required', 'unique:menuses', 'max:20'],
            'menu_name_kr'  => ['required', 'max:20'],
        ], $Messages::$menu['validate']);

        $create_result = menus::create([
            'menu_id'           => $menu_id,
            'menu_name_en'      => addslashes($menu_name_en),
            'menu_name_kr'      => addslashes($menu_name_kr),
            'menu_display'      => $menu_display,
            'menu_rank'         => $menu_rank,
            'menu_page_type'    => $menu_page_type,
            'menu_content'      => $menu_content,
        ])->exists();

        if($create_result = 1) return redirect()->route('adm.menu.index')->with('alert_messages', $Messages::$menu['insert']['in_ok']);
        else return redirect()->route('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function menu_add(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $page       = $request->input('page');
        $menu_id    = $request->input('menu_id');

        if($menu_id == ""){
            return redirect()->route('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
            exit;
        }

        $path = 'data/menu';     //첨부물 저장 경로
        if (!is_dir($path)) {
            @mkdir($path, 0755);
            @chmod($path, 0755);
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $edit_directory = "data/menu/editor";
        setcookie('directory', $edit_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $menu_name = DB::table('menuses')->select('menu_name_kr','menu_name_en')->where('menu_id', $menu_id)->first();   //카테고리 이름 가져 오기

        //코드 자동 생성
        $len = strlen($menu_id);
        if ($len == 6){
            return redirect()->route('adm.menu.index')->with('alert_messages', $Messages::$menu['insert']['menu_no']);
            exit;
        }

        $len2 = $len + 1;

        $max_menu_id = DB::select(" select MAX(SUBSTRING(menu_id,$len2,2)) as max_subid from menuses where SUBSTRING(menu_id,1,$len) = '$menu_id' ");
        $subid = base_convert($max_menu_id[0]->max_subid, 36, 10);
        $subid += 36;

        if ($subid >= 36 * 36)
        {
        // 빈상태로
            $subid = "  ";
        }

        $subid = base_convert($subid, 10, 36);
        $subid = substr("00" . $subid, -2);
        $subid = $menu_id . $subid;

        $sublen = strlen($subid);

        return view('adm.menu.menu_add',[
            'mk_menu_id'        => $subid,
            'page'              => $page,
            'menu_name_kr'      => $menu_name->menu_name_kr,
        ]);
    }

    public function menu_add_save(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $menu_id            = $request->input('menu_id');
        $menu_name_en       = $request->input('menu_name_en');
        $menu_name_kr       = $request->input('menu_name_kr');
        $menu_display       = $request->input('menu_display');
        $menu_rank          = $request->input('menu_rank');
        $menu_page_type     = $request->input('menu_page_type');
        $menu_content       = $request->input('menu_content');

        if($menu_rank == "") $menu_rank = 0;

        if($menu_id == "")
        {
            return redirect('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //스마트 에디터 시간 초과 파악
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        //데이터를 get 방식으로 전달 받아야만 유효성 검사 리턴을 할수 있다!!!
        Validator::validate($request->all(), [
            'menu_id'       => ['required', 'unique:menuses', 'max:6'],
            'menu_name_en'  => ['required', 'unique:menuses', 'max:20'],
            'menu_name_kr'  => ['required', 'max:20'],
        ], $Messages::$menu['validate']);

        $create_result = menus::create([
            'menu_id'           => $menu_id,
            'menu_name_en'      => addslashes($menu_name_en),
            'menu_name_kr'      => addslashes($menu_name_kr),
            'menu_display'      => $menu_display,
            'menu_rank'         => $menu_rank,
            'menu_page_type'    => $menu_page_type,
            'menu_content'      => $menu_content,
        ])->exists();

        if($create_result = 1) return redirect()->route('adm.menu.index')->with('alert_messages', $Messages::$menu['insert']['in_ok']);
        else return redirect()->route('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function menu_modi(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $menu_id    = $request->input('menu_id');
        $page       = $request->input('page');

        if($menu_id == "")
        {
            return redirect('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $edit_directory = "data/menu/editor";
        setcookie('directory', $edit_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $menu_info = DB::table('menuses')->where('menu_id', $menu_id)->first();   //카테고리 정보 가져 오기

        return view('adm.menu.menu_modi',[
            'page'          => $page,
            'menu_info'     => $menu_info,
        ]);
    }

    public function modi_save(Request $request,menus $menu)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id                 = $request->input('id');
        $menu_id            = $request->input('menu_id');
        $menu_name_kr       = $request->input('menu_name_kr');
        $menu_display       = $request->input('menu_display');
        $menu_rank          = $request->input('menu_rank');
        $menu_page_type     = $request->input('menu_page_type');
        $menu_content       = $request->input('menu_content');
        $page               = $request->input('page');

        if($menu_rank == "") $menu_rank = 0;

        if($id == "" || $menu_id == "")
        {
            return redirect('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //스마트 에디터 시간 초과 파악
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        //데이터를 get 방식으로 전달 받아야만 유효성 검사 리턴을 할수 있다!!!
        //영문명은 수정 되지 않게 함!!
        Validator::validate($request->all(), [
            'menu_name_kr'  => ['required', 'max:20'],
        ], $Messages::$menu['validate']);

        //DB 저장 배열 만들기
        $data = array(
            'menu_name_kr'    => addslashes($menu_name_kr),
            'menu_display'    => $menu_display,
            'menu_rank'       => $menu_rank,
            'menu_page_type'  => $menu_page_type,
            'menu_content'    => $menu_content,
        );

        $update_result = DB::table('menuses')->where([['id', $id],['menu_id',$menu_id]])->limit(1)->update($data);

        if($update_result = 1) return redirect()->route('adm.menu.index','&page='.$page)->with('alert_messages', $Messages::$menu['update']['up_ok']);
        else return redirect('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
    }

    public function delete_save(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id            = $request->input('id');
        $menu_id       = $request->input('menu_id');
        $page          = $request->input('page');

        if($id == "" || $menu_id == ""){
            return redirect('adm.menu.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $down_memu_info = DB::table('menuses')->where([['id',$id],['menu_id','like',$menu_id.'%']])->count();   //하위 카테고리 갯수

        if($down_memu_info == 1){
            $menu_info = DB::table('menuses')->where([['id', $id], ['menu_id',$menu_id]])->first();   //메뉴 정보 읽기

            $editor_path = "data/menu/editor";     //스마트 에디터 첨부 저장 경로

            //스마트 에디터 내용에 첨부된 이미지 색제
            $editor_img_del = CustomUtils::editor_img_del($menu_info->menu_content, $editor_path);

            $menu_del = DB::table('menuses')->where([['id',$id],['menu_id',$menu_id]])->delete();   //row 삭제
            if($menu_del){
                return redirect()->route('adm.menu.index','page='.$page)->with('alert_messages', $Messages::$menu['del']['del_ok']);
            }else{
                return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);
            }
        }else{
            return redirect()->route('adm.menu.index','page='.$page)->with('alert_messages', $Messages::$menu['del']['del_chk']);
        }
    }

}
