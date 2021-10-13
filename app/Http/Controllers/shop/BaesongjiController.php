<?php
#############################################################################
#
#		파일이름		:		BaesongjiController.php
#		파일설명		:		배송지 처리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 08일
#		최종수정일		:		2021년 10월 08일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증

class BaesongjiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        session_start();
        $this->middleware('auth');
    }

    public function ajax_baesongji(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        if(!Auth::user()){
            echo "no_mem";
            exit;
        }

        $baesongjis = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->orderBy('ad_default', 'desc')->orderBy('id', 'desc')->get();

        $view = view('shop.ajax_baesongji',[
            'baesongjis'    => $baesongjis,
        ]);

        return $view;
    }

    public function ajax_baesongji_modify(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $chk        = $request->input('chk');
        $id         = $request->input('id');
        $ad_subject = $request->input('ad_subject_ori');
        $ad_default = $request->input('ad_default_ori');

        if(!Auth::user() || count($chk) == 0){
            echo "no_mem";
            exit;
        }

        for($i=0; $i<count($chk); $i++)
        {
            $k = isset($chk[$i]) ? (int)$chk[$i] : 0;
            $id = isset($id[$k]) ? (int)$id[$k] : 0;
            $ad_subject = isset($ad_subject[$k]) ? $ad_subject[$k] : '';

            //if(!empty($ad_default) && $id === $ad_default) {  //$id === $ad_default 이부분 처리 해야함
            if(!empty($ad_default)) {
                $update_result = DB::table('baesongjis')->where([['id', $id], ['user_id',Auth::user()->user_id]])->limit(1)->update(['ad_subject' => $ad_subject, 'ad_default' => 1]);
            }else{
                $update_result = DB::table('baesongjis')->where([['id', $id], ['user_id',Auth::user()->user_id]])->limit(1)->update(['ad_subject' => $ad_subject]);
            }
        }

        echo "ok";
        exit;
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
