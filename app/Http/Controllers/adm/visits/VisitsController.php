<?php
#############################################################################
#
#		파일이름		:		VisitsController.php
#		파일설명		:		관리자페이지 - 방문자 통계 리스트
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 30일
#		최종수정일		:		2021년 08월 30일
#
###########################################################################-->

namespace App\Http\Controllers\adm\visits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Models\Visits;    //모델 정의
use App\Models\Membervisits;    //모델 정의
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class VisitsController extends Controller
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
        $type = 'visits';

        $page_control = CustomUtils::page_function('visits',$pageNum,$writeList,$pageNumList,$type,'','','','');
        $visits = DB::table($type)->orderBy('id', 'desc')->skip($page_control['startNum'])->take($writeList)->get();

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        //오늘 통계 구하기
        $today = DB::table($type)->where('created_at', 'like' ,date('Y-m-d',time()).'%')->count();

        //어제 통계 구하기
        $yesterday = DB::table($type)->whereRaw("date(created_at) = date(subdate(now(),INTERVAL 1 DAY))")->count();

        //삭제 관련(2021.09.07)
        $min_date = DB::table($type)->min('created_at');

        if(is_null($min_date)) $min_date = date("Y",time());

        $min_year = (int)substr($min_date, 0, 4);
        $now_year = (int)substr(date("Y-m-d H:i:s",time()), 0, 4);

        return view('adm.visits.visitslist', [
            'virtual_num'   => $page_control['virtual_num'],
            'totalCount'    => $page_control['totalCount'],
            'today'         => $today,
            'yesterday'     => $yesterday,
            'visits'        => $visits,
            'pageNum'       => $page_control['pageNum'],
            'pageList'      => $pageList,
            'min_year'      => $min_year,
            'now_year'      => $now_year,
        ]); // 요청된 정보 처리 후 결과 되돌려줌
    }

    public function memberindex(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $pageNum     = $request->input('page');
        $writeList   = 10;  //10갯씩 뿌리기
        $pageNumList = 10; // 한 페이지당 표시될 글 갯수
        $type = 'membervisits';

        $page_control = CustomUtils::page_function('membervisits',$pageNum,$writeList,$pageNumList,$type,'','','','');
        $membervisits = DB::table($type)->orderBy('id', 'desc')->skip($page_control['startNum'])->take($writeList)->get();

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        //오늘 통계 구하기
        $today = DB::table($type)->where('created_at', 'like' ,date('Y-m-d',time()).'%')->count();

        //어제 통계 구하기
        $yesterday = DB::table($type)->whereRaw("date(created_at) = date(subdate(now(),INTERVAL 1 DAY))")->count();

        //삭제 관련(2021.09.07)
        $min_date = DB::table($type)->min('created_at');

        if(is_null($min_date)) $min_date = date("Y",time());

        $min_year = (int)substr($min_date, 0, 4);
        $now_year = (int)substr(date("Y-m-d H:i:s",time()), 0, 4);

        return view('adm.visits.membervisitslist', [
            'virtual_num'   => $page_control['virtual_num'],
            'totalCount'    => $page_control['totalCount'],
            'today'         => $today,
            'yesterday'     => $yesterday,
            'membervisits'  => $membervisits,
            'pageNum'       => $page_control['pageNum'],
            'pageList'      => $pageList,
            'min_year'      => $min_year,
            'now_year'      => $now_year,
        ]); // 요청된 정보 처리 후 결과 되돌려줌
    }

    public function membervisits_del(Request $request)
    {
        //회원 통계 삭제
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $year       = $request->input('year');
        $month      = $request->input('month');
        $method     = $request->input('method');

        $year = preg_replace('/[^0-9]/', '', $year);
        $month = preg_replace('/[^0-9]/', '', $month);

        $del_date = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT);

        switch($method) {
            case 'before':
                $sql_common = " where substring(created_at, 1, 7) < '$del_date' ";
                break;
            case 'specific':
                $sql_common = " where substring(created_at, 1, 7) = '$del_date' ";
                break;
        }

        //통계 삭제
        $del_sql = DB::select("delete from membervisits {$sql_common}");

        return redirect()->route('adm.membervisit.index')->with('alert_messages', $Messages::$board_editor['editor']['del_ok']);
        exit;
    }

    public function visits_del(Request $request)
    {
        //방문자 통계 삭제
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $year       = $request->input('year');
        $month      = $request->input('month');
        $method     = $request->input('method');

        $year = preg_replace('/[^0-9]/', '', $year);
        $month = preg_replace('/[^0-9]/', '', $month);

        $del_date = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT);

        switch($method) {
            case 'before':
                $sql_common = " where substring(created_at, 1, 7) < '$del_date' ";
                break;
            case 'specific':
                $sql_common = " where substring(created_at, 1, 7) = '$del_date' ";
                break;
        }

        //통계 삭제
        $del_sql = DB::select("delete from visits {$sql_common}");

        return redirect()->route('adm.visit.index')->with('alert_messages', $Messages::$board_editor['editor']['del_ok']);
        exit;
    }

}
