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

</form>

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
@endphp
    <tr>
        <td>
            <table>
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
                        <button type="button" class="btn_address" onclick="win_zip('forderform', 'od_zip', 'od_addr1', 'od_addr2', 'od_addr3', 'od_addr_jibeon');">주소 검색</button>
<div id="wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
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
</table>


<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    // 우편번호 찾기 찾기 화면을 넣을 element
    var element_wrap = document.getElementById('wrap');

    function foldDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_wrap.style.display = 'none';
    }

    function win_zip() {
        // 현재 scroll 위치를 저장해놓는다.
        var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    document.getElementById("od_addr3").value = extraAddr;

                } else {
                    document.getElementById("od_addr3").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('od_zip').value = data.zonecode;
                document.getElementById("od_addr1").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("od_addr2").focus();
                document.getElementById("od_addr1").value = addr;
                document.getElementById("od_addr_jibeon").value = data.userSelectedType;

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_wrap.style.display = 'none';

                // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
                document.body.scrollTop = currentScroll;
            },
            // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
            onresize : function(size) {
                element_wrap.style.height = size.height+'px';
            },
            width : '100%',
            height : '100%'
        }).embed(element_wrap);

        // iframe을 넣은 element를 보이게 한다.
        element_wrap.style.display = 'block';
    }
</script>

@endsection
