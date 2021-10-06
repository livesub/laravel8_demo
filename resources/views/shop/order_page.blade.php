@extends('layouts.shophead')

@section('content')

<table border=1>
    <tr>
        <td><h4>주문서 작성</h4></td>
    </tr>
</table>


<form name="forderform" id="forderform" method="post" action="" autocomplete="off">
<table border=1>
    <tr>
        <th scope="col">상품명</th>
        <th scope="col">총수량</th>
        <th scope="col">판매가</th>
        <th scope="col">소계</th>
        <th scope="col">포인트</th>
        <th scope="col">배송비</th>
    </tr>
    @php
        $tot_point = 0;
        $tot_sell_price = 0;

        $goods = $goods_it_id = "";
        $goods_count = -1;

        $good_info = '';
        $it_send_cost = 0;
        $it_cp_count = 0;

        $comm_tax_mny = 0; // 과세금액
        $comm_vat_mny = 0; // 부가세
        $comm_free_mny = 0; // 면세금액
        $tot_tax_mny = 0;
    @endphp
    @foreach($cart_infos as $cart_info)
        @php
            $i = 0;
            $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where item_code = '{$cart_info->item_code}' and od_id = '$s_cart_id' ");

            if (!$goods)
            {
                //$goods = addslashes($row[it_name]);
                //$goods = get_text($row[it_name]);
                $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $cart_info->item_name);
                $goods_item_code = $cart_info->item_code;
            }
            $goods_count++;
            $image = $CustomUtils->get_item_image($cart_info->item_code, 3);
            $item_name = '<b>' . stripslashes($cart_info->item_name) . '</b>';
            $item_options = $CustomUtils->print_item_options($cart_info->item_code, $s_cart_id);
            if($item_options) {
                $item_name .= '<div class="sod_opt">'.$item_options.'</div>';
            }

            $point      = $sum[0]->point;
            $sell_price = $sum[0]->price;

            // 쿠폰
            $cp_button = '';

            if(Auth::user()) {      //회원일때
/*
                $cp_count = 0;

                $sql = " select cp_id
                            from {$g5['g5_shop_coupon_table']}
                            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_minimum <= '$sell_price'
                              and (
                                    ( cp_method = '0' and cp_target = '{$row['it_id']}' )
                                    OR
                                    ( cp_method = '1' and ( cp_target IN ( '{$row['ca_id']}', '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
                                  ) ";
                $res = sql_query($sql);

                for($k=0; $cp=sql_fetch_array($res); $k++) {
                    if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                        continue;

                    $cp_count++;
                }

                if($cp_count) {
                    $cp_button = '<button type="button" class="cp_btn">쿠폰적용</button>';
                    $it_cp_count++;
                }
*/
            }

            // 배송비
            switch($cart_info->sct_send_cost)
            {
                case 1:
                    $ct_send_cost = '착불';
                    break;
                case 2:
                    $ct_send_cost = '무료';
                    break;
                default:
                    $ct_send_cost = '선불';
                    break;
            }

            // 조건부무료
            if($cart_info->item_sc_type == 2) {
                $sendcost = $CustomUtils->get_item_sendcost($cart_info->item_code, $sum[0]->price, $sum[0]->qty, $s_cart_id);

                if($sendcost == 0) $ct_send_cost = '무료';
            }
        @endphp
            <tr>
                <td>
                    <table>
                        <tr>
                            <td><img src="{{ asset($image) }}"></td>
                            <td>
                                <table>
                                    <input type="hidden" name="item_code[{{ $i }}]"    value="{{ $cart_info->item_code }}">
                                    <input type="hidden" name="item_name[{{ $i }}]"  value="{{ $cart_info->item_name }}">
                                    <input type="hidden" name="it_price[{{ $i }}]" value="{{ $sell_price }}">
                                    <input type="hidden" name="cp_id[{{ $i }}]" value="">
                                    <input type="hidden" name="cp_price[{{ $i }}]" value="0">

                                    {!! $item_name !!}
                                    {!! $cp_button !!}
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>

                <td>
                    {{ number_format($sum[0]->qty) }}
                </td>
            </tr>
        @php
            $i++;
        @endphp
    @endforeach
</table>

</form>






@endsection
