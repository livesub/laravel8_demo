<?php

namespace App\Http\Controllers\adm\cate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크
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
        $writeList   = 10;  //10갯씩 뿌리기
        $pageNumList = 10; // 한 페이지당 표시될 글 갯수
        $type = 'cate';

        $page_control = CustomUtils::page_function('categorys',$pageNum,$writeList,$pageNumList,$type,'','','','');

        $cate_infos = DB::table('categorys')->where('ca_display', 'Y')->orderby('ca_rank', 'DESC')->skip($page_control['startNum'])->take($writeList)->get();   //정보 읽기

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.category.catelist',[
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            "cate_infos"        => $cate_infos,
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
        ],$Messages::$mypage['mypage']['message']);

    }

    public function addcategory(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        $cate_1_infos = DB::table('categorys')->select('ca_id','ca_name_kr','ca_name_en')->where('ca_display', 'Y')->orderby('ca_rank', 'DESC')->get();   //정보 읽기

        $ca_id     = $request->input('ca_id');
        if($ca_id != ""){   //2차 카테 찾기
            $cate_2_infos = DB::table('categorys')->select('ca_id','ca_name_kr')->where([['ca_display', 'Y'],['ca_id',$ca_id]])->orderby('ca_rank', 'DESC')->get();   //정보 읽기
        }
dd("5차 까지 어떻게 할것인지 고민!!");
        return view('adm.category.cateadd',[
            'cate_1_infos'        => $cate_1_infos,
            'ca_id'             => $ca_id,
        ],$Messages::$mypage['mypage']['message']);
    }


    public function addcategorysave(Request $request)
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id     = $request->input('ca_id');

        if($ca_id == "")    //1차 카테고리
        {
            $max_info = DB::table('categorys')->select('ca_id')->max('ca_id');
            if($max_info == ""){
                $ca_id = "01";
            }else{
                $ca_id = sprintf("%02d",($max_info + 1));
            }
        }else{  //있다면 2차 카테고리...

        }

        $ca_name_kr     = $request->input('ca_name_kr');
        $ca_name_en     = $request->input('ca_name_en');
        $ca_display     = $request->input('ca_display');
        $ca_rank        = $request->input('ca_rank');

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
        //
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
