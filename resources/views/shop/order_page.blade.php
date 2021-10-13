@extends('layouts.shophead')

@section('content')

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('/js/zip.js') }}"></script>

<table border=1>
    <tr>
        <td><h4>주문서 작성</h4></td>
    </tr>
</table>


<form name="forderform" id="forderform" method="post" action="" autocomplete="off">
{!! csrf_field() !!}
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

            if(Auth::user()) {      //회원일때(이부분 쿠폰은 분석을 더 해 봐야 함!!)
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
                                    <input type="hidden" name="item_code[{{ $i }}]" value="{{ $cart_info->item_code }}">
                                    <input type="hidden" name="item_name[{{ $i }}]" value="{{ $cart_info->item_name }}">
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
                <td>
                    {{ number_format($cart_info->sct_price) }}
                </td>
                <td>
                    {{ number_format($sell_price) }}
                </td>
                <td>
                    {{ number_format($point) }}
                </td>
                <td>
                    {{ $ct_send_cost }}
                </td>

            </tr>
        @php
            $i++;
            $tot_point      += $point;
            $tot_sell_price += $sell_price;
        @endphp
    @endforeach

    @php
        // 배송비 계산
        $send_cost = $CustomUtils->get_sendcost($s_cart_id);
    @endphp
</table>



<table border=1>
<input type="hidden" name="od_price"    value="{{ $tot_sell_price }}">
<input type="hidden" name="org_od_price"    value="{{ $tot_sell_price }}">
<input type="hidden" name="od_send_cost" value="{{ $send_cost }}">
<input type="hidden" name="od_send_cost2" value="0">
<input type="hidden" name="item_coupon" value="0">
<input type="hidden" name="od_coupon" value="0">
<input type="hidden" name="od_send_coupon" value="0">
<input type="hidden" name="od_goods_name" value="{{ $goods }}">
@php
/* pg 사 연결
        // 결제대행사별 코드 include (결제대행사 정보 필드)
        require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');

        if($is_kakaopay_use) {
            require_once(G5_SHOP_PATH.'/kakaopay/orderform.2.php');
        }
*/
@endphp
    <tr>
        <td>
            <table border=1>
                <!-- 주문하시는 분 입력  -->
                <tr>
                    <td><h2>주문하시는 분</h2></td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_name">이름<strong class="sound_only"> 필수</strong></label></th>
                    <td><input type="text" name="od_name" value="{{ $user_name }}" id="od_name" required class="frm_input required" maxlength="20"></td>
                </tr>

                @if(!Auth::user())
                <tr>
                    <th scope="row"><label for="od_pwd">비밀번호</label></th>
                    <td>
                        <span class="frm_info">영,숫자 3~20자 (주문서 조회시 필요)</span>
                        <input type="password" name="od_pwd" id="od_pwd" required class="frm_input required" maxlength="20">
                    </td>
                </tr>
                @endif
                <tr>
                    <th scope="row"><label for="od_tel">전화번호<strong class="sound_only"> 필수</strong></label></th>
                    <td><input type="text" name="od_tel" value="{{ $user_tel }}" id="od_tel" required class="frm_input required" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_hp">핸드폰</label></th>
                    <td><input type="text" name="od_hp" value="{{ $user_phone }}" id="od_hp" class="frm_input" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row">주소</th>
                    <td>
                        <label for="od_zip" class="sound_only">우편번호<strong class="sound_only"> 필수</strong></label>
                        <input type="text" name="od_zip" value="{{ $user_zip }}" id="od_zip" required class="frm_input required" size="8" maxlength="6" placeholder="우편번호">
                        <button type="button" class="btn_address" onclick="win_zip('wrap','od_zip', 'od_addr1', 'od_addr2', 'od_addr3', 'od_addr_jibeon','btnFoldWrap');">주소 검색</button>
<div id="wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
    <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" alt="접기 버튼">
</div>
                        <br>
                        <input type="text" name="od_addr1" value="{{ $user_addr1 }}" id="od_addr1" required class="frm_input frm_address required" size="60" placeholder="기본주소">
                        <label for="od_addr1" class="sound_only">기본주소<strong class="sound_only"> 필수</strong></label><br>
                        <input type="text" name="od_addr2" value="{{ $user_addr2 }}" id="od_addr2" class="frm_input frm_address" size="60" placeholder="상세주소">
                        <label for="od_addr2" class="sound_only">상세주소</label>
                        <br>
                        <input type="text" name="od_addr3" value="{{ $user_addr3 }}" id="od_addr3" class="frm_input frm_address" size="60" readonly="readonly" placeholder="참고항목">
                        <label for="od_addr3" class="sound_only">참고항목</label><br>
                        <input type="hidden" name="od_addr_jibeon" id="od_addr_jibeon" value="{{ $user_addr_jibeon }}">
                    </td>
                </tr>
                <!-- 주문하시는 분 입력 끝 -->

                <!-- 받으시는 분 입력 시작  -->
                <tr>
                    <td><h2>받으시는 분</h2></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="disp_baesongi"></div>
                    </td>
                </tr>

                <tr>
                    <td>배송지선택</td>
                    <td>{!! $addr_list !!}</td>
                </tr>

                @if(Auth::user())
                <tr>
                    <th scope="row"><label for="ad_subject">배송지명</label></th>
                    <td>
                        <input type="text" name="ad_subject" id="ad_subject" class="frm_input" maxlength="20">
                        <input type="checkbox" name="ad_default" id="ad_default" value="1">
                        <label for="ad_default">기본배송지로 설정</label>
                    </td>
                </tr>
                @endif

                <tr>
                    <th scope="row"><label for="od_b_name">이름<strong class="sound_only"> 필수</strong></label></th>
                    <td><input type="text" name="od_b_name" id="od_b_name" required class="frm_input required" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_b_tel">전화번호<strong class="sound_only"> 필수</strong></label></th>
                    <td><input type="text" name="od_b_tel" id="od_b_tel" required class="frm_input required" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_b_hp">핸드폰</label></th>
                    <td><input type="text" name="od_b_hp" id="od_b_hp" class="frm_input" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row">주소</th>
                    <td id="sod_frm_addr">
                        <label for="od_b_zip" class="sound_only">우편번호<strong class="sound_only"> 필수</strong></label>
                        <input type="text" name="od_b_zip" id="od_b_zip" required class="frm_input required" size="8" maxlength="6" placeholder="우편번호">
                        <button type="button" class="btn_address" onclick="win_zip('wrap_b','od_b_zip', 'od_b_addr1', 'od_b_addr2', 'od_b_addr3', 'od_b_addr_jibeon', 'btnFoldWrap_b');">주소 검색</button>
<div id="wrap_b" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
    <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap_b" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" alt="접기 버튼">
</div>
                        <br>
                        <input type="text" name="od_b_addr1" id="od_b_addr1" required class="frm_input frm_address required" size="60" placeholder="기본주소">
                        <label for="od_b_addr1" class="sound_only">기본주소<strong> 필수</strong></label><br>
                        <input type="text" name="od_b_addr2" id="od_b_addr2" class="frm_input frm_address" size="60" placeholder="상세주소">
                        <label for="od_b_addr2" class="sound_only">상세주소</label>
                        <br>
                        <input type="text" name="od_b_addr3" id="od_b_addr3" readonly="readonly" class="frm_input frm_address" size="60" placeholder="참고항목">
                        <label for="od_b_addr3" class="sound_only">참고항목</label><br>
                        <input type="hidden" name="od_b_addr_jibeon" value="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_memo">전하실말씀</label></th>
                    <td><textarea name="od_memo" id="od_memo"></textarea></td>
                </tr>
                <!-- 받으시는 분 입력 끝 -->
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>dfbdb</td>
                </tr>
            </table>
        </td>
    </tr>
</form>
</table>

<script>
    function baesongji(){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji') }}',
            data : {
            },
            dataType : 'text',
            success : function(result){
                if(result == "no_mem"){
                    alert("회원이시라면 회원로그인 후 이용해 주십시오.");
                    return false;
                }

                $("#disp_baesongi").html(result);
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    $("input[name=ad_sel_addr]").on("click", function() {
//        var addr = $("#addr"+num).val().split(String.fromCharCode(30));
//        alert(addr);
        $("#od_b_name").val($("#od_name").val());
        $("#od_b_tel").val($("#od_tel").val());
        $("#od_b_hp").val($("#od_hp").val());
        $("#od_b_zip").val($("#od_zip").val());
        $("#od_b_addr1").val($("#od_addr1").val());
        $("#od_b_addr2").val($("#od_addr2").val());
        $("#od_b_addr3").val($("#od_addr3").val());
        $("#od_b_addr_jibeon").val($("#od_addr_jibeon").val());
        $("#ad_subject").val($("#ad_subject").val());
/*
        $("#od_b_name").val(addr[0]);
        $("#od_b_tel").val(addr[1]);
        $("#od_b_hp").val(addr[2]);
        $("#od_b_zip").val(addr[3]);
        $("#od_b_addr1").val(addr[4]);
        $("#od_b_addr2").val(addr[5]);
        $("#od_b_addr3").val(addr[6]);
        $("#od_b_addr_jibeon").val(addr[7]);
        $("#ad_subject").val(addr[8]);

        var addr = $(this).val().split(String.fromCharCode(30));

        if (addr[0] == "same") {
            gumae2baesong();
        } else {
            if(addr[0] == "new") {
                for(i=0; i<10; i++) {
                    addr[i] = "";
                }
            }

            var f = document.forderform;
            f.od_b_name.value        = addr[0];
            f.od_b_tel.value         = addr[1];
            f.od_b_hp.value          = addr[2];
            f.od_b_zip.value         = addr[3] + addr[4];
            f.od_b_addr1.value       = addr[5];
            f.od_b_addr2.value       = addr[6];
            f.od_b_addr3.value       = addr[7];
            f.od_b_addr_jibeon.value = addr[8];
            f.ad_subject.value       = addr[9];

            var zip1 = addr[3].replace(/[^0-9]/g, "");
            var zip2 = addr[4].replace(/[^0-9]/g, "");

            var code = String(zip1) + String(zip2);

            if(zipcode != code) {
                calculate_sendcost(code);
            }
        }
*/
    });
</script>





@endsection
