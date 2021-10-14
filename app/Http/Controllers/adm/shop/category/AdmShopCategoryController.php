<?php

namespace App\Http\Controllers\adm\shop\category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\shopcategorys;    //카테고리 모델 정의

class AdmShopCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $pageNum     = $request->input('page');
        $writeList   = 10;  //10갯씩 뿌리기
        $pageNumList = 10; // 한 페이지당 표시될 글 갯수
        $type = 'shopcate';

        $page_control = CustomUtils::page_function('shopcategorys',$pageNum,$writeList,$pageNumList,$type,'','','','');

        $scate_infos = DB::table('shopcategorys')->orderby('sca_id', 'ASC')->skip($page_control['startNum'])->take($writeList)->get();   //정보 읽기

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.shop.category.cate_list',[
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            "scate_infos"       => $scate_infos,
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
        ],$Messages::$mypage['mypage']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function catecreate(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $sca_id      = $request->input('sca_id');

        //코드 자동 생성
        $len        = strlen($sca_id);
        if ($len == 10){
            return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$category['insert']['cate_no']);
            exit;
        }

        $len2 = $len + 1;

        $max_sca_id = DB::select(" select MAX(SUBSTRING(sca_id,$len2,2)) as max_subid from shopcategorys where SUBSTRING(sca_id,1,$len) = '$sca_id' ");
        $subid = base_convert($max_sca_id[0]->max_subid, 36, 10);
        $subid += 36;

        if ($subid >= 36 * 36)
        {
        // 빈상태로
            $subid = "  ";
        }

        $subid = base_convert($subid, 10, 36);
        $subid = substr("00" . $subid, -2);
        $subid = $sca_id . $subid;

        $sublen = strlen($subid);

        return view('adm.shop.category.cate_create',[
            'mk_sca_id'          => $subid,
        ],$Messages::$mypage['mypage']);
    }

    public function createsave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mk_sca_id     = $request->input('mk_sca_id');

        if($mk_sca_id == "")    //1차 카테고리
        {
            return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $sca_id          = $mk_sca_id;
        $sca_name_kr     = $request->input('sca_name_kr');
        $sca_name_en     = $request->input('sca_name_en');
        $sca_display     = $request->input('sca_display');
        $sca_rank        = $request->input('sca_rank');

        if($sca_rank == "") $sca_rank = 0;

        $create_result = shopcategorys::create([
            'sca_id'      => $sca_id,
            'sca_name_kr' => addslashes($sca_name_kr),
            'sca_name_en' => addslashes($sca_name_en),
            'sca_display' => $sca_display,
            'sca_rank'    => $sca_rank,
        ])->exists();

        if($create_result) return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$category['insert']['in_ok']);
        else return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function cate_add(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $page        = $request->input('page');
        $sca_id      = $request->input('sca_id');

        if($sca_id == ""){
            return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
            exit;
        }

        $categorys_name = DB::table('shopcategorys')->select('sca_name_kr','sca_name_en')->where('sca_id', $sca_id)->first();   //카테고리 이름 가져 오기

        //코드 자동 생성
        $len = strlen($sca_id);
        if ($len == 10){
            return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$category['insert']['cate_no']);
            exit;
        }

        $len2 = $len + 1;

        $max_sca_id = DB::select(" select MAX(SUBSTRING(sca_id,$len2,2)) as max_subid from shopcategorys where SUBSTRING(sca_id,1,$len) = '$sca_id' ");
        $subid = base_convert($max_sca_id[0]->max_subid, 36, 10);
        $subid += 36;

        if ($subid >= 36 * 36)
        {
        // 빈상태로
            $subid = "  ";
        }

        $subid = base_convert($subid, 10, 36);
        $subid = substr("00" . $subid, -2);
        $subid = $sca_id . $subid;

        $sublen = strlen($subid);

        return view('adm.shop.category.cate_add',[
            'mk_sca_id'         => $subid,
            'page'              => $page,
            'sca_name_kr'       => $categorys_name->sca_name_kr,
        ]);
    }

    public function cate_add_save(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mk_sca_id     = $request->input('mk_sca_id');

        if($mk_sca_id == "")
        {
            return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $sca_id          = $mk_sca_id;
        $sca_name_kr     = $request->input('sca_name_kr');
        $sca_name_en     = $request->input('sca_name_en');
        $sca_display     = $request->input('sca_display');
        $sca_rank        = $request->input('sca_rank');
        $page           = $request->input('page');

        if($sca_rank == "") $sca_rank = 0;

        $create_result = shopcategorys::create([
            'sca_id'      => $sca_id,
            'sca_name_kr' => addslashes($sca_name_kr),
            'sca_name_en' => addslashes($sca_name_en),
            'sca_display' => $sca_display,
            'sca_rank'    => $sca_rank,
        ])->exists();

        if($create_result) return redirect()->route('shop.cate.index','&page='.$page)->with('alert_messages', $Messages::$category['insert']['in_ok']);
        else return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function cate_modi(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $sca_id     = $request->input('sca_id');
        $page       = $request->input('page');

        if($sca_id == "")
        {
            return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $categorys_info = DB::table('shopcategorys')->where('sca_id', $sca_id)->first();   //카테고리 정보 가져 오기

        return view('adm.shop.category.cate_modi',[
            'page'              => $page,
            'categorys_info'    => $categorys_info,
        ]);
    }

    public function cate_modi_save(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id             = $request->input('id');
        $sca_id         = $request->input('sca_id');
        $page           = $request->input('page');
        $sca_name_kr     = $request->input('sca_name_kr');
        $sca_name_en     = $request->input('sca_name_en');
        $sca_display     = $request->input('sca_display');
        $sca_rank        = $request->input('sca_rank');

        if($id == "" || $sca_id == "")
        {
            return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //DB 저장 배열 만들기
        $data = array(
            'sca_name_kr'    => addslashes($sca_name_kr),
            'sca_display'    => $sca_display,
        );

        if($sca_name_en == "") $data['sca_name_en'] = "";
        else $data['sca_name_en'] = addslashes($sca_name_en);

        if($sca_rank == "") $data['sca_rank'] = 0;
        else $data['sca_rank'] = $sca_rank;

        //$update_result = DB::table('shopcategorys')->where([['id', $id],['sca_id',$sca_id]])->limit(1)->update($data);
        $update_result = Shopcategorys::find($id)->update($data);

        if($update_result) return redirect()->route('shop.cate.index','&page='.$page)->with('alert_messages', $Messages::$category['update']['up_ok']);
        else return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function cate_delete(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id             = $request->input('id');
        $sca_id          = $request->input('sca_id');
        $page           = $request->input('page');

        //blade 에서 제어 했으나 한번더 제어 함(하위 카테고리가 있거나 상품이 있을 경우 삭제 안되게)
        $de_cate_info = DB::table('shopcategorys')->where('sca_id','like',$sca_id.'%')->count();   //하위 카테고리 갯수
        $de_item_info = DB::table('shopitems')->where('sca_id','like',$sca_id.'%')->count();   //상품 갯수

        if($de_cate_info == 1 && $de_item_info == 0){
            $cate_del = DB::table('shopcategorys')->where([['id',$id],['sca_id',$ca_id]])->delete();   //row 삭제
            if($cate_del){
                return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$category['cate_del']['cate_del_ok']);
            }else{
                return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
            }
        }else{
            return redirect()->route('shop.cate.index','page='.$page)->with('alert_messages', $Messages::$category['del']['del_chk']);
        }
    }
}
