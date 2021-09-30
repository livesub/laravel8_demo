<?php
#############################################################################
#
#		파일이름		:		CartController.php
#		파일설명		:		장바구니,바로구매 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 29일
#		최종수정일		:		2021년 09월 29일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use App\Models\shopcarts;    //장바구니 모델 정의

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_cart_register(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        $CustomUtils = new CustomUtils;

        $sw_direct  = $request->input('sw_direct');     //장바구니 0, 바로구매 1

        session_start();    //라라벨에서 세션이 바로 적용 되지 않기에 임시 방편으로 작업

        $CustomUtils->set_cart_id($sw_direct);

        if($sw_direct) $tmp_cart_id = $CustomUtils->get_session('ss_cart_direct');
        else $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');

        $tmp_cart_id = preg_replace('/[^a-z0-9_\-]/i', '', $tmp_cart_id);

        $act = $request->input('act');
        $ct_chk = $request->input('ct_chk');
        $post_ct_chk = (isset($ct_chk) && is_array($ct_chk)) ? $ct_chk : array();

        $item_code = $request->input('item_code');
        $post_item_codes = (isset($item_code) && is_array($item_code)) ? $item_code : array();

        if($act == "buy")
        {


        }else if ($act == "alldelete"){ // 모두 삭제이면


        }else if ($act == "seldelete"){ // 선택삭제

        }else{ // 장바구니에 담기
            $count = count($post_item_codes);

            if ($count < 1){
                echo "no_carts";
                exit;
            }

            $ct_count = 0;
            $chk_it_id = $request->input('chk_it_id');
            $post_chk_it_id = (isset($chk_it_id) && is_array($chk_it_id)) ? $chk_it_id : array();
            $sio_id = $request->input('sio_id');
            $post_io_ids = (isset($sio_id) && is_array($sio_id)) ? $sio_id : array();
            $sio_type = $request->input('sio_type');
            $post_io_types = (isset($sio_type) && is_array($sio_type)) ? $sio_type : array();
            $sct_qty = $request->input('ct_qty');
            $post_ct_qtys = (isset($sct_qty) && is_array($sct_qty)) ? $sct_qty : array();

            for($i=0; $i<$count; $i++) {
                // 보관함의 상품을 담을 때 체크되지 않은 상품 건너뜀
                if($act == 'multi' && ! (isset($post_chk_it_id[$i]) && $post_chk_it_id[$i])) continue;

                $item_code = isset($post_item_codes[$i]) ? $post_item_codes[$i] : '';

                if( !$item_code ) continue;

                $opt_count = (isset($post_io_ids[$item_code]) && is_array($post_io_ids[$item_code])) ? count($post_io_ids[$item_code]) : 0;

                if($opt_count && isset($post_io_types[$item_code][0]) && $post_io_types[$item_code][0] != 0)
                {
                    echo "no_option";
                    exit;
                }

                // 상품정보
                $item_info = $CustomUtils->get_shop_item($item_code, false);

                if(!$item_info[0]->item_code){
                    echo "no_items";
                    exit;
                }

                // 바로구매에 있던 장바구니 자료를 지운다.
                if($i == 0 && $sw_direct == 1){
                    //장바구니 삭제 로직
                    DB::table('shopcarts')->where([['od_id',$tmp_cart_id], ['sct_direct',1]])->delete();   //row 삭제
                }

                // 옵션정보를 얻어서 배열에 저장
                $opt_list = array();
                $opt_infos = DB::table('shopitemoptions')->where([['item_code', $item_code], ['sio_use',1]])->orderby('id', 'asc')->get();

                $lst_count = 0;

                foreach($opt_infos as $opt_info){
                    $opt_list[$opt_info->sio_type][$opt_info->sio_id]['id'] = $opt_info->sio_id;
                    $opt_list[$opt_info->sio_type][$opt_info->sio_id]['use'] = $opt_info->sio_use;
                    $opt_list[$opt_info->sio_type][$opt_info->sio_id]['price'] = $opt_info->sio_price;
                    $opt_list[$opt_info->sio_type][$opt_info->sio_id]['stock'] = $opt_info->sio_stock_qty;

                    // 선택옵션 개수
                    if(!$opt_info->sio_type) $lst_count++;
                }

                //--------------------------------------------------------
                //  재고 검사, 바로구매일 때만 체크
                //--------------------------------------------------------
                // 이미 주문폼에 있는 같은 상품의 수량합계를 구한다.
                if($sw_direct) {
                    for($k=0; $k<$opt_count; $k++) {
                        $sio_id = $request->input('sio_id');
                        $sio_id = isset($sio_id[$item_code][$k]) ? $sio_id[$item_code][$k] : '';
                        $sio_type = $request->input('sio_type');
                        $sio_type = isset($sio_type[$item_code][$k]) ? $sio_type[$item_code][$k] : '';
                        $sio_value = $request->input('sio_value');
                        $sio_value = isset($sio_value[$item_code][$k]) ? $sio_value[$item_code][$k] : '';
                        $sct_qty = $request->input('ct_qty');

                        $sum_qty = DB::table('shopcarts')->where([['od_id','<>',$tmp_cart_id], ['item_code',$item_code], ['sio_id',$sio_id], ['sio_type',$sio_type], ['sct_stock_use','0'], ['sct_status','쇼핑'], ['sct_select','1']])->sum('sct_qty');

                        // 재고 구함
                        $sct_qty = isset($sct_qty[$item_code][$k]) ? (int) $sct_qty[$item_code][$k] : 0;

                        if(!$sio_id)
                            $it_stock_qty = $CustomUtils->get_item_stock_qty($item_code);
                        else
                            $it_stock_qty = $CustomUtils->get_option_stock_qty($item_code, $sio_id, $sio_type);

                        if ($sct_qty + $sum_qty > $it_stock_qty)
                        {
                            echo "no_qty";
                            exit;
                        }
                    }
                }
                //--------------------------------------------------------

                // 옵션수정일 때 기존 장바구니 자료를 먼저 삭제
                if($act == 'optionmod') DB::table('shopcarts')->where([['od_id',$tmp_cart_id], ['item_code',$item_code]])->delete();   //row 삭제

                // 장바구니에 Insert
                // 바로구매일 경우 장바구니가 체크된것으로 강제 설정
                if($sw_direct) {
                    $sct_select = 1;
                    $sct_select_time = date("Y-m-d H:i:s",time());
                } else {
                    $sct_select = 0;
                    $sct_select_time = '0000-00-00 00:00:00';
                }

                // 장바구니에 Insert
                $comma = '';
                for($k=0; $k<$opt_count; $k++) {
                    $sio_id = $request->input('sio_id');
                    $sio_id = isset($sio_id[$item_code][$k]) ? $sio_id[$item_code][$k] : '';
                    $sio_type = $request->input('sio_type');
                    $sio_type = isset($sio_type[$item_code][$k]) ? $sio_type[$item_code][$k] : '';
                    $sio_value = $request->input('sio_value');
                    $sio_value = isset($sio_value[$item_code][$k]) ? $sio_value[$item_code][$k] : '';
                    $sct_qty = $request->input('ct_qty');

                    // 선택옵션정보가 존재하는데 선택된 옵션이 없으면 건너뜀
                    if($lst_count && $sio_id == '') continue;

                    // 구매할 수 없는 옵션은 건너뜀
                    if($sio_id && !$opt_list[$sio_type][$sio_id]['use']) continue;

                    $sio_price = isset($opt_list[$sio_type][$sio_id]['price']) ? $opt_list[$sio_type][$sio_id]['price'] : 0;
                    $sct_qty = isset($sct_qty[$item_code][$k]) ? (int) $sct_qty[$item_code][$k] : 0;

                    // 구매가격이 음수인지 체크
                    if($sio_type) {
                        if((int)$sio_price < 0){
                            echo "negative_price";
                            exit;
                        }
                    } else {
                        if((int)$item_info[0]->item_price + (int)$sio_price < 0){
                            echo "negative_price";
                            exit;
                        }
                    }

                    // 동일옵션의 상품이 있으면 수량 더함
                    $sam_opt = DB::table('shopcarts')->select('id','sio_type','sct_qty')->where([['od_id',$tmp_cart_id],['item_code',$item_code],['sio_id',$sio_id],['sct_status','쇼핑']])->get();

                    if(isset($sam_opt[0]->id) && $sam_opt[0]->id) {
                        // 재고체크
                        $tmp_ct_qty = $sam_opt[0]->sct_qty;

                        if(!$sio_id)
                            $tmp_it_stock_qty = $CustomUtils->get_item_stock_qty($item_code);
                        else
                            $tmp_it_stock_qty = $CustomUtils->get_option_stock_qty($item_code, $sio_id, $sam_opt[0]->sio_type);

                        if ($tmp_ct_qty + $sct_qty > $tmp_it_stock_qty)
                        {
                            echo "no_qty";
                            exit;
                        }

                        $up_result = shopcarts::whereid($sam_opt[0]->id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
                        $up_result->sct_qty = $up_result->sct_qty + 1;
                        $result_up = $up_result->save();

                        continue;
                    }

                    // 포인트
                    $point = 0;
                    $setting_info = $CustomUtils->setting_infos();

                    if($setting_info->company_use_point == 1) {
                        if($sio_type == 0) {
                            $point = $CustomUtils->get_item_point($item_info[0], $sio_id);
                        } else {
                            $point = $item_info[0]->item_supply_point;
                        }

                        if($point < 0) $point = 0;
                    }

                    // 배송비결제
                    $sct_send_cost = $request->input('sct_send_cost');
                    $sct_send_cost = isset($sct_send_cost) ? (int)$sct_send_cost : 0;

                    if($item_info[0]->item_sc_type == 1) $sct_send_cost = 2; // 무료
                    else if($item_info[0]->item_sc_type > 1 && $item_info[0]->item_sc_method == 1) $sct_send_cost = 1; // 착불

                    $sio_value = strip_tags($sio_value);
                    $remote_addr = $_SERVER['REMOTE_ADDR'];

                    if(Auth::user() != ""){
                        $user_id = Auth::user()->user_id;
                    }else{
                        $user_id = "";
                    }

                    //DB 저장 배열 만들기
                    $data = array(
                        'od_id'             => $tmp_cart_id,
                        'user_id'           => $user_id,
                        'item_code'         => $item_info[0]->item_code,
                        'item_name'         => addslashes($item_info[0]->item_name),
                        'item_sc_type'      => (int)$item_info[0]->item_sc_type,
                        'item_sc_method'    => (int)$item_info[0]->item_sc_method,
                        'item_sc_price'     => (int)$item_info[0]->item_sc_price,
                        'item_sc_minimum'   => (int)$item_info[0]->item_sc_minimum,
                        'item_sc_qty'       => (int)$item_info[0]->item_sc_qty,
                        'sct_status'        => '쇼핑',
                        'sct_history'       => '',
                        'sct_price'         => (int)$item_info[0]->item_price,
                        'sct_point'         => (int)$point,
                        'sct_point_use'     => 0,
                        'sct_stock_use'     => 0,
                        'sct_option'        => $sio_value,
                        'sct_qty'           => (int)$sct_qty,
                        'sio_id'            => $sio_id,
                        'sio_type'          => (int)$sio_type,
                        'sio_price'         => (int)$sio_price,
                        'sct_ip'            => $remote_addr,
                        'sct_send_cost'     => (int)$sct_send_cost,
                        'sct_direct'        => (int)$sw_direct,
                        'sct_select'        => (int)$sct_select,
                        'sct_select_time'   => $sct_select_time,
                    );

                    $in_result = shopcarts::create($data);
                    $in_result->save();
                }
            }
        }

        //페이지 이동
        if ($sw_direct)
        {
            //바로구매 일 경우
            echo "buy_page";
            exit;
        }else{
            //장바구니 일 경우
            echo "cart_page";
            exit;
        }
    }

    public function cartlist(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

dd("cartlist");
    }

    public function index()
    {
        //
dd("들어옴~~~~");
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
