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
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class VisitsContoller extends Controller
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

        return view('adm.visits.visitslist', [
            'virtual_num'=>$page_control['virtual_num'],
            'totalCount'=>$page_control['totalCount'],
            'visits'=>$visits,
            'pageNum'=>$page_control['pageNum'],
            'pageList'=>$pageList
        ]); // 요청된 정보 처리 후 결과 되돌려줌
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
