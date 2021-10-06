@extends('layouts.shophead')

@section('content')

<script src="{{ asset('/js/shop_js/shop.js') }}"></script>
<script src="{{ asset('/js/shop_js/shop_override.js') }}"></script>

<table border=1>
    <tr>
        <td><h4>장바구니</h4></td>
    </tr>
</table>

<form name="frmcartlist" id="sod_bsk_list" method="post" action="{{ route('ajax_cart_register') }}">
<input type="hidden" name="ajax_option_url" id="ajax_option_url" value="{{ route('ajax_option_change') }}">
{!! csrf_field() !!}
<table border=1>
    <tr>
        <td><input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked"></td>
        <td>상품명</td>
        <td>총수량</td>
        <td>판매가</td>
        <td>포인트</td>
        <td>배송비</td>
        <td>소계</td>
    </tr>

    @php
        $tot_point = 0;
        $tot_sell_price = 0;
        $send_cost = 0;
    @endphp

    @foreach($cart_infos as $cart_info)
        @php
            $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where item_code = '{$cart_info->item_code}' and od_id = '$s_cart_id' ");

            if ($num == 0) { // 계속쇼핑
                $continue_ca_id = $cart_info->sca_id;
            }

            //이미지
            $image_url = $CustomUtils->get_item_image($cart_info->item_code, 3);

            //제목
            $item_name = stripslashes($cart_info->item_name);

            //옵션 처리
            $item_options = $CustomUtils->print_item_options($cart_info->item_code, $s_cart_id);

            if($item_options) {
                $mod_options = '<tr><td><div class="sod_option_btn"><button type="button" class="mod_options">선택사항수정</button></div></td></tr>';
                $item_name .= '<div class="sod_opt">'.$item_options.'</div>';
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

            $point      = $sum[0]->point;
            $sell_price = $sum[0]->price;

        @endphp
    <tr>
        <td><input type="checkbox" name="ct_chk[{{ $num }}]" value="1" id="ct_chk_{{ $num }}" checked="checked"></td>
        <td>
            <table border=1>
                <tr>
                    <td><a href="{{ route('sitemdetail','item_code='.$cart_info->item_code) }}"><img src="{{ asset($image_url) }}"></a></td>
                    <td>
                        <table>
                            <tr>
                                <td>
                    <input type="hidden" name="item_code[{{ $num }}]" id="item_code{{ $num }}" value="{{ $cart_info->item_code }}">
                    <input type="hidden" name="item_name[{{ $num }}]" id="item_name{{ $num }}" value="{{ $cart_info->item_name }}">
                                    <a href="{{ route('sitemdetail','item_code='.$cart_info->item_code) }}">{!! $item_name !!}</a>
                                    {!! $mod_options !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td>{{ number_format($sum[0]->qty) }}</td>
        <td>{{ number_format($cart_info->sct_price) }}</td>
        <td>{{ number_format($point) }}</td>
        <td>{{ $ct_send_cost }}</td>
        <td><span id="sell_price_{{ $num }}" class="total_prc">{{ number_format($sell_price) }}</span></td>
    </tr>
        @php
            $num++;
            $tot_point      += $point;
            $tot_sell_price += $sell_price;
        @endphp

    @endforeach

    @php
        if ($num == 0) {
            echo '<tr><td colspan="7" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
        } else {
            // 배송비 계산
            $send_cost = $CustomUtils->get_sendcost($s_cart_id, 0);
        }
    @endphp
</table>

@if($num > 0)
<table border=1>
    <tr>
        <button type="button" onclick="return form_check('seldelete');">선택삭제</button>
        <button type="button" onclick="return form_check('alldelete');">비우기</button>
    </tr>
</table>
@endif

@php
    $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
@endphp

@if ($tot_price > 0 || $send_cost > 0)
<table border=1>
    <tr>
        <td>배송비</td>
        <td><strong>{{ number_format($send_cost)  }}</strong> 원</td>
        <td>포인트</td>
        <td><strong>{{ number_format($tot_point)  }}</strong> 점</td>
        <td>총계 가격</td>
        <td><strong>{{ number_format($tot_price) }}</strong> 원</td>
    </tr>
</table>
@endif


<table>
    <tr>
        <td>
@if($num == 0)
            <a href="{{ route('index') }}" class="btn01">쇼핑 계속하기</a>
@else
            <table>
                <tr>
                    <td>
                        <input type="hidden" name="url" value="./orderform.php">
                        <input type="hidden" name="records" value="{{ $num }}">
                        <input type="hidden" name="act" id="act" value="">
                        <a href="{{ route('sitem','ca_id='.$continue_ca_id) }}">쇼핑 계속하기</a>
                        <button type="button" onclick="return form_check('buy');" class="btn_submit">주문하기</button>
                    </td>
                </tr>
            </table>
@endif

        </td>
    </tr>
</table>
</form>




<script>
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        //var item_code = $(this).closest("tr").find("input[name^=item_code]").val();
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));
        var item_code = $("#item_code"+close_btn_idx).val();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_choice_option_modify') }}',
            data : {
                item_code : item_code,
            },
            dataType : 'text',
            success : function(result){
//alert(result);
                if(result == "no_item"){
                    alert("상품이 없습니다.");
                }

                if(result == "no_cart"){
                    alert("장바구니에 상품이 없습니다.");
                }

                $("#mod_option_frm").remove();
                $this.after("<div id=\"mod_option_frm\"></div><div class=\"mod_option_bg\"></div>");
                $("#mod_option_frm").html(result);
                price_calculate();
            },
            error: function(result){
                console.log(result);
            },
        });
    });

    // 모두선택
    $("input[name=ct_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=ct_chk]").attr("checked", true);
        else
            $("input[name^=ct_chk]").attr("checked", false);
    });

    // 옵션수정 닫기
    $(document).on("click", "#mod_option_close", function() {
        $("#mod_option_frm, .mod_option_bg").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });

});

function fsubmit_check(f) {
    if($("input[name^=ct_chk]:checked").length < 1) {
        alert("구매하실 상품을 하나이상 선택해 주십시오.");
        return false;
    }

    return true;
}

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if (act == "buy")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("주문하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        $("#act").val(act);
        var queryString = $("form[name=frmcartlist]").serialize() ;
        $.ajax({
            type : 'post',
            url : '{{ route('ajax_cart_register') }}',
            data : queryString,
            dataType : 'text',
            success : function(result){
//alert(result);
                if(result == "no_item"){
                    alert("주문하실 상품을 하나이상 선택해 주십시오.");
                    return false;
                }

                if(result == "no_qty"){
                    alert("재고수량이 부족합니다.");
                    return false;
                }

                if(result == "mem_order"){  //회원 주문
                    location.href = "{{ route('orderform') }}";
                }

                if(result == "no_mem_order"){  //비회원 주문
                    location.href = "{{ route('login.index','url='.urlencode(route('orderform'))) }}";
                }
            },
            error: function(result){
                console.log(result);
            },
        });


//        f.act.value = act;
//        f.submit();
    }
    else if (act == "alldelete")
    {
        if (confirm("정말 비우시겠습니까?") == true){    //확인
            $("#act").val(act);

            var queryString = $("form[name=frmcartlist]").serialize() ;
            $.ajax({
                type : 'post',
                url : '{{ route('ajax_cart_register') }}',
                data : queryString,
                dataType : 'text',
                success : function(result){
//alert(result);
                    if(result == "cart_page"){
                        location.href = "{{ route('cartlist') }}";
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }
        //f.submit();
    }
    else if (act == "seldelete")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("삭제하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            $("#act").val(act);

            var queryString = $("form[name=frmcartlist]").serialize() ;
            $.ajax({
                type : 'post',
                url : '{{ route('ajax_cart_register') }}',
                data : queryString,
                dataType : 'text',
                success : function(result){
    //alert(result);
                    if(result == "no_cnt"){
                        alert("삭제하실 상품을 하나이상 선택해 주십시오.");
                        return false;
                    }

                    if(result == "cart_page"){
                        location.href = "{{ route('cartlist') }}";
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }else{
            return false;
        }
    }
}
</script>





@endsection
