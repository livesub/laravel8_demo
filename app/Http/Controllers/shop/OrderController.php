<?php
#############################################################################
#
#		파일이름		:		OrderController.php
#		파일설명		:		주문서 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 01일
#		최종수정일		:		2021년 10월 01일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        session_start();
    }

    public function orderform(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $sw_direct  = $request->input('sw_direct');     //장바구니 0, 바로구매 1

        $CustomUtils->set_session("ss_direct", $sw_direct);

        if($sw_direct){
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_direct');
        }else{
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');
        }

        if ($CustomUtils->get_cart_count($tmp_cart_id) == 0){
            return redirect()->route('cartlist')->with('alert_messages', '장바구니가 비어 있습니다.');
            exit;
        }

        if(!$CustomUtils->before_check_cart_price($tmp_cart_id)){
            return redirect()->route('cartlist')->with('alert_messages', '장바구니 금액에 변동사항이 있습니다.\n장바구니를 다시 확인해 주세요.');
            exit;
        }

        // 새로운 주문번호 생성
        $od_id = $CustomUtils->get_uniqid();
        $CustomUtils->set_session('ss_order_id', $od_id);
        $s_cart_id = $tmp_cart_id;
/*
        if($default['de_pg_service'] == 'inicis' || $default['de_inicis_lpay_use'] || $default['de_inicis_kakaopay_use'])
            set_session('ss_order_inicis_id', $od_id);
*/
        $tot_price = 0;
        $tot_point = 0;
        $tot_sell_price = 0;

        $goods = $goods_item_code = "";
        $goods_count = -1;

        $cart_infos = DB::table('shopcarts as a')
            ->select('a.id', 'a.item_code', 'a.item_name', 'a.sct_price', 'a.sct_point', 'a.sct_qty', 'a.sct_status', 'a.sct_send_cost', 'a.item_sc_type', 'b.sca_id')
            ->leftjoin('shopitems as b', function($join) {
                    $join->on('a.item_code', '=', 'b.item_code');
                })
            ->where([['a.od_id',$s_cart_id], ['a.sct_select','1']])
            ->groupBy('a.item_code')
            ->orderBy('a.id')
            ->get();


            $user_name = '';
            $user_tel = '';
            $user_phone = '';
            $user_zip = '';
            $user_addr1 = '';
            $user_addr2 = '';
            $user_addr3 = '';
            $user_addr_jibeon = '';

            if(Auth::user()->user_name != "") $user_name = Auth::user()->user_name;
            if(Auth::user()->user_tel != "") $user_tel = Auth::user()->user_tel;
            if(Auth::user()->user_phone != "") $user_phone = Auth::user()->user_phone;
            if(Auth::user()->user_zip != "") $user_zip = Auth::user()->user_zip;
            if(Auth::user()->user_addr1 != "") $user_addr1 = Auth::user()->user_addr1;
            if(Auth::user()->user_addr2 != "") $user_addr2 = Auth::user()->user_addr2;
            if(Auth::user()->user_addr3 != "") $user_addr3 = Auth::user()->user_addr3;
            if(Auth::user()->user_addr_jibeon != "") $user_addr_jibeon = Auth::user()->user_addr_jibeon;

        return view('shop.order_page',[
            's_cart_id'     => $s_cart_id,
            'cart_infos'    => $cart_infos,
            'CustomUtils'   => $CustomUtils,

            'user_name'     => $user_name,
            'user_tel'      => $user_tel,
            'user_phone'    => $user_phone,
            'user_zip'      => $user_zip,
            'user_addr1'    => $user_addr1,
            'user_addr2'    => $user_addr2,
            'user_addr3'    => $user_addr3,
            'user_addr_jibeon'  => $user_addr_jibeon,
        ],$Messages::$blade_ment['login']);

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
