<?php

namespace App\Http\Controllers\adm\cate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\categorys;    //카테고리 모델 정의


class AdmcateContoller extends Controller
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
        $writeList   = 20;  //10갯씩 뿌리기
        $pageNumList = 20; // 한 페이지당 표시될 글 갯수
        $type = 'cate';

        $page_control = CustomUtils::page_function('categorys',$pageNum,$writeList,$pageNumList,$type,'','','','');

        //$cate_infos = DB::table('categorys')->orderby('ca_id', 'ASC')->orderby('ca_rank', 'DESC')->skip($page_control['startNum'])->take($writeList)->get();   //정보 읽기
        $cate_infos = DB::table('categorys')->orderby('ca_id', 'ASC')->skip($page_control['startNum'])->take($writeList)->get();   //정보 읽기

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.category.catelist',[
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            "cate_infos"        => $cate_infos,
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
        ],$Messages::$mypage['mypage']['message']);
    }

    public function catecreate(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id      = $request->input('ca_id');

        //코드 자동 생성
        $len        = strlen($ca_id);
        if ($len == 10){
            return redirect()->route('adm.cate.indx')->with('alert_messages', $Messages::$category['insert']['cate_no']);
            exit;
        }

        $len2 = $len + 1;

        $max_ca_id = DB::select(" select MAX(SUBSTRING(ca_id,$len2,2)) as max_subid from categorys where SUBSTRING(ca_id,1,$len) = '$ca_id' ");
        $subid = base_convert($max_ca_id[0]->max_subid, 36, 10);
        $subid += 36;

        if ($subid >= 36 * 36)
        {
        // 빈상태로
            $subid = "  ";
        }

        $subid = base_convert($subid, 10, 36);
        $subid = substr("00" . $subid, -2);
        $subid = $ca_id . $subid;

        $sublen = strlen($subid);

        return view('adm.category.catecreate',[
            'mk_ca_id'          => $subid,
        ],$Messages::$mypage['mypage']['message']);
    }

    public function catecreatesave(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mk_ca_id     = $request->input('mk_ca_id');

        if($mk_ca_id == "")    //1차 카테고리
        {
            return redirect('adm.cate.indx')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $ca_id          = $mk_ca_id;
        $ca_name_kr     = $request->input('ca_name_kr');
        $ca_name_en     = $request->input('ca_name_en');
        $ca_display     = $request->input('ca_display');
        $ca_rank        = $request->input('ca_rank');

        if($ca_rank == "") $ca_rank = 0;

        $create_result = categorys::create([
            'ca_id'      => $ca_id,
            'ca_name_kr' => addslashes($ca_name_kr),
            'ca_name_en' => addslashes($ca_name_en),
            'ca_display' => $ca_display,
            'ca_rank'    => $ca_rank,
        ])->exists();

        if($create_result = 1) return redirect()->route('adm.cate.indx')->with('alert_messages', $Messages::$category['insert']['in_ok']);
        else return redirect()->route('adm.cate.indx')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }


    public function cate_add(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $page        = $request->input('page');
        $ca_id        = $request->input('ca_id');

        if($ca_id == ""){
            return redirect()->route('adm.cate.indx')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
            exit;
        }

        $categorys_name = DB::table('categorys')->select('ca_name_kr','ca_name_en')->where('ca_id', $ca_id)->first();   //카테고리 이름 가져 오기

        //코드 자동 생성
        $len = strlen($ca_id);
        if ($len == 10){
            return redirect()->route('adm.cate.indx')->with('alert_messages', $Messages::$category['insert']['cate_no']);
            exit;
        }

        $len2 = $len + 1;

        $max_ca_id = DB::select(" select MAX(SUBSTRING(ca_id,$len2,2)) as max_subid from categorys where SUBSTRING(ca_id,1,$len) = '$ca_id' ");
        $subid = base_convert($max_ca_id[0]->max_subid, 36, 10);
        $subid += 36;

        if ($subid >= 36 * 36)
        {
        // 빈상태로
            $subid = "  ";
        }

        $subid = base_convert($subid, 10, 36);
        $subid = substr("00" . $subid, -2);
        $subid = $ca_id . $subid;

        $sublen = strlen($subid);

        return view('adm.category.cate_add',[
            'mk_ca_id'          => $subid,
            'page'              => $page,
            'ca_name_kr'        => $categorys_name->ca_name_kr,
        ]);
    }


    public function cate_add_save(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mk_ca_id     = $request->input('mk_ca_id');

        if($mk_ca_id == "")
        {
            return redirect('adm.cate.indx')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $ca_id          = $mk_ca_id;
        $ca_name_kr     = $request->input('ca_name_kr');
        $ca_name_en     = $request->input('ca_name_en');
        $ca_display     = $request->input('ca_display');
        $ca_rank        = $request->input('ca_rank');
        $page           = $request->input('page');

        if($ca_rank == "") $ca_rank = 0;

        $create_result = categorys::create([
            'ca_id'      => $ca_id,
            'ca_name_kr' => addslashes($ca_name_kr),
            'ca_name_en' => addslashes($ca_name_en),
            'ca_display' => $ca_display,
            'ca_rank'    => $ca_rank,
        ])->exists();

        if($create_result = 1) return redirect()->route('adm.cate.indx','&page='.$page)->with('alert_messages', $Messages::$category['insert']['in_ok']);
        else return redirect()->route('adm.cate.indx')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function cate_modi(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id   = $request->input('ca_id');
        $page       = $request->input('page');

        if($ca_id == "")
        {
            return redirect('adm.cate.indx')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $categorys_info = DB::table('categorys')->where('ca_id', $ca_id)->first();   //카테고리 정보 가져 오기

        return view('adm.category.cate_modi',[
            'page'              => $page,
            'categorys_info'    => $categorys_info,
        ]);
    }

    public function cate_modi_save(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id             = $request->input('id');
        $ca_id          = $request->input('ca_id');
        $page           = $request->input('page');
        $ca_name_kr     = $request->input('ca_name_kr');
        $ca_name_en     = $request->input('ca_name_en');
        $ca_display     = $request->input('ca_display');
        $ca_rank        = $request->input('ca_rank');

        if($id == "" || $ca_id == "")
        {
            return redirect('adm.cate.indx')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //DB 저장 배열 만들기
        $data = array(
            'ca_name_kr'    => addslashes($ca_name_kr),
            'ca_display'    => $ca_display,
        );

        if($ca_name_en == "") $data['ca_name_en'] = "";
        else $data['ca_name_en'] = addslashes($ca_name_en);

        if($ca_rank == "") $data['ca_rank'] = 0;
        else $data['ca_rank'] = $ca_rank;

        $update_result = DB::table('categorys')->where([['id', $id],['ca_id',$ca_id]])->limit(1)->update($data);

        if($update_result = 1) return redirect()->route('adm.cate.indx','&page='.$page)->with('alert_messages', $Messages::$category['update']['up_ok']);
        else return redirect('adm.cate.indx')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);  //치명적인 에러가 있을시
    }

    public function cate_delete(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id             = $request->input('id');
        $ca_id          = $request->input('ca_id');
        $page           = $request->input('page');

        $cate_del = DB::table('categorys')->where([['id',$id],['ca_id',$ca_id]])->delete();   //row 삭제
        if($cate_del){
            return redirect()->route('adm.cate.indx','page='.$page)->with('alert_messages', $Messages::$category['del']['del_ok']);
        }else{
            return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['message']['error']);
        }
    }


}
