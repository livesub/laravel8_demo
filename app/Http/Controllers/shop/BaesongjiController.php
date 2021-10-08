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

        // 기본배송지
        $default_baesongji = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['ad_default','1']])->first();

        $sep = chr(30);
        $addr_list = "";

        if(isset($default_baesongji->id) && $default_baesongji->id) {
            $val1 = $default_baesongji->ad_name.$sep.$default_baesongji->ad_tel.$sep.$default_baesongji->ad_hp.$sep.$default_baesongji->ad_zip1.$sep.$default_baesongji->ad_zip2.$sep.$default_baesongji->ad_addr1.$sep.$default_baesongji->ad_addr2.$sep.$default_baesongji->ad_addr3.$sep.$default_baesongji->ad_jibeon.$sep.$default_baesongji->ad_subject;
            $addr_list .= '<input type="radio" name="ad_sel_addr" value="'.$val1.'" id="ad_sel_addr_def">'.PHP_EOL;
            $addr_list .= '<label for="ad_sel_addr_def">기본배송지</label>'.PHP_EOL;
        }

/*
    삭제처리
        if($w == 'd') {
            $sql = " delete from {$g5['g5_shop_order_address_table']} where mb_id = '{$member['mb_id']}' and ad_id = '$ad_id' ";
            sql_query($sql);
            goto_url($_SERVER['SCRIPT_NAME']);
        }
*/
        //$baesongji = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->count(); //배송지 갯수

        $baesongjis = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->orderBy('ad_default', 'desc')->orderBy('id', 'desc')->get();

        $view = view('shop.ajax_baesongji',[
            'baesongjis' => $baesongjis,
        ]);

        return $view;
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
