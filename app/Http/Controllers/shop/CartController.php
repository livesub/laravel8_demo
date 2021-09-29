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

        $CustomUtils->set_cart_id($sw_direct);
        $tmp_cart_id = session()->get('ss_cart_id');

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
            $ct_qty = $request->input('ct_qty');
            $post_ct_qtys = (isset($ct_qty) && is_array($ct_qty)) ? $ct_qty : array();

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
                $item = $CustomUtils->get_shop_item($item_code, false);

                if(!$item[0]->item_code){
                    echo "no_items";
                    exit;
                }

                // 바로구매에 있던 장바구니 자료를 지운다.
                if($i == 0 && $sw_direct == 1){
                    //장바구니 삭제 로직
                    //$result_del = DB::table('board_datas_comment_tables')->where('id',$c_id)->delete();   //row 삭제
                    //sql_query(" delete from {$g5['g5_shop_cart_table']} where od_id = '$tmp_cart_id' and ct_direct = 1 ", false);
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
                    $sio_id = $request->input('sio_id');



                    for($k=0; $k<$opt_count; $k++) {
                        $sio_id = $sio_id[$item_code][$k];
                        var_dump($sio_id);
/*
                        $io_id = isset($_POST['io_id'][$item_code][$k]) ? preg_replace(G5_OPTION_ID_FILTER, '', $_POST['io_id'][$it_id][$k]) : '';
                        $io_type = isset($_POST['io_type'][$it_id][$k]) ? preg_replace('#[^01]#', '', $_POST['io_type'][$it_id][$k]) : '';
                        $io_value = isset($_POST['io_value'][$it_id][$k]) ? $_POST['io_value'][$it_id][$k] : '';
*/
                    }
/*
                    for($k=0; $k<$opt_count; $k++) {
                        $io_id = isset($_POST['io_id'][$it_id][$k]) ? preg_replace(G5_OPTION_ID_FILTER, '', $_POST['io_id'][$it_id][$k]) : '';
                        $io_type = isset($_POST['io_type'][$it_id][$k]) ? preg_replace('#[^01]#', '', $_POST['io_type'][$it_id][$k]) : '';
                        $io_value = isset($_POST['io_value'][$it_id][$k]) ? $_POST['io_value'][$it_id][$k] : '';

                        $sql = " select SUM(ct_qty) as cnt from {$g5['g5_shop_cart_table']}
                                where od_id <> '$tmp_cart_id'
                                    and it_id = '$it_id'
                                    and io_id = '$io_id'
                                    and io_type = '$io_type'
                                    and ct_stock_use = 0
                                    and ct_status = '쇼핑'
                                    and ct_select = '1' ";
                        $row = sql_fetch($sql);
                        $sum_qty = $row['cnt'];

                        // 재고 구함
                        $ct_qty = isset($_POST['ct_qty'][$it_id][$k]) ? (int) $_POST['ct_qty'][$it_id][$k] : 0;
                        if(!$io_id)
                            $it_stock_qty = get_it_stock_qty($it_id);
                        else
                            $it_stock_qty = get_option_stock_qty($it_id, $io_id, $io_type);

                        if ($ct_qty + $sum_qty > $it_stock_qty)
                        {
                            alert($io_value." 의 재고수량이 부족합니다.\\n\\n현재 재고수량 : " . number_format($it_stock_qty - $sum_qty) . " 개");
                        }
                    }
*/
                }
                //--------------------------------------------------------

                var_dump($lst_count);



                exit;

            }

        }









        exit;


















echo "ㄴㅇㅍㄴㅇ";
//        $sw_direct = (isset($_REQUEST['sw_direct']) && $_REQUEST['sw_direct']) ? 1 : 0;

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
