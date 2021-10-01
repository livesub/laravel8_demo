@extends('layouts.shophead')

@section('content')

<script src="{{ asset('/js/shop_js/shop.js') }}"></script>
<script src="{{ asset('/js/shop_js/shop_override.js') }}"></script>

<table border="1">
    <tr>
        <td>
            <table border=1>
                <tr>
                    <td colspan="10">
                        <table>
                            <tr>
                                <td><img src="{{ $big_img_disp }}" id="big_img"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    @php
                        $m = 1;
                    @endphp

                    @if(count($small_img_disp) > 0)
                        @for($k = 0; $k < count($small_img_disp); $k++)
                    <td><img src="{{ $small_img_disp[$k] }}" onMouseover="ajax_big_img_change('{{ $item_info->item_code }}','{{ $small_item_img[$k] }}');"></td>
                            @if($m % 5 == 0)
                                </tr>
                                <tr>
                            @endif
                            @php
                                $m++;
                            @endphp
                        @endfor
                    @endif

                </tr>
            </table>
        </td>
        <td>


<form name="fitem" id="fitem" method="post" action="{{ route('ajax_cart_register') }}">
{!! csrf_field() !!}
<input type="hidden" name="item_code[]" value="{{ $item_info->item_code }}">
<input type="hidden" name="ajax_option_url" id="ajax_option_url" value="{{ route('ajax_option_change') }}">
<input type="hidden" name="sw_direct" id="sw_direct">
<input type="hidden" name="url" id="url">

            <table border=1 class="renewal_itemform">
                <tr>
                    <td colspan="2"><b>{{ stripslashes($item_info->item_name) }}</b></td>
                </tr>

                @if($item_info->item_basic != "")
                <tr>
                    <td colspan="2">{{ $item_info->item_basic }}</td>
                </tr>
                @endif

                @if($item_info->item_use != 1)
                <!-- 판매 가능이 아닐때 -->
                <tr>
                    <td>판매가격</td>
                    <td>판매중지</td>
                </tr>

                @elseif($item_info->item_tel_inq == 1)
                <!-- 전화문의일 경우 -->
                <tr>
                    <td>판매가격</td>
                    <td>전화문의</td>
                </tr>
                @else
                <!-- 전화문의가 아닐 경우 -->
                    @if($item_info->item_cust_price != "0")
                <tr>
                    <td>시중가격</td>
                    <td>{{ $CustomUtils->display_price($item_info->item_cust_price) }}</td>
                </tr>
                    @endif

                <tr>
                    <td>판매가격</td>
                    <td>
	                    <strong>{{ $CustomUtils->display_price($item_info->item_price) }}</strong>
	                    <input type="hidden" id="item_price" value="{{ $item_info->item_price }}">
                    </td>
                </tr>
                @endif

                @if($item_info->item_manufacture != "")
                <tr>
                    <td>제조사</td>
                    <td>{{ $item_info->item_manufacture }}</td>
                </tr>
                @endif

                @if($item_info->item_origin != "")
                <tr>
                    <td>원산지</td>
                    <td>{{ $item_info->item_origin }}</td>
                </tr>
                @endif

                @if($item_info->item_brand != "")
                <tr>
                    <td>브랜드</td>
                    <td>{{ $item_info->item_brand }}</td>
                </tr>
                @endif

                @if($item_info->item_model != "")
                <tr>
                    <td>모델</td>
                    <td>{{ $item_info->item_model }}</td>
                </tr>
                @endif

                @if($use_point == 1)
                <tr>
                    <td>포인트</td>
                    <td>{{ $use_point_disp }}</td>
                </tr>
                @endif

                <tr>
                    <td>배송비결제</td>
                    <td>{!! $sc_method_disp !!}</td>
                </tr>

                @if($is_orderable)
                <tr>
                    <td colspan=2>
                        <table border=1 style="width:100%">
                            @if($option_item)

                            <tr>
                                <td>선택옵션</td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="sit_option">
                                        <tr>
                                            <td>
                                                {!! $option_item !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endif

                            @if($supply_item)
                            <tr>
                                <td>추가옵션</td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="sit_option">
                                        <tr>
                                            <td>
                                                {!! $supply_item !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endif

                            <tr>
                                <td>
                                    <!-- 선택된 옵션 시작 { -->
                                    <section id="sit_sel_option">
                                        @if(!$option_item)
                                        <!-- 선택 옵션이 없을때 처리 -->
                                        <ul id="sit_opt_added">
                                            <li class="sit_opt_list">
                                                <input type="hidden" name="sio_type[{{ $item_info->item_code }}][]" value="0">
                                                <input type="hidden" name="sio_id[{{ $item_info->item_code }}][]" value="">
                                                <input type="hidden" name="sio_value[{{ $item_info->item_code }}][]" value="{{ $item_info->item_name }}">
                                                <input type="hidden" class="sio_price" value="0">
                                                <input type="hidden" class="sio_stock" value="{{ $item_info->item_stock_qty}}">
                                                <div class="opt_name">
                                                    <span class="item_opt_subj">{{ $item_info->item_name }}</span>
                                                </div>
                                                <div class="opt_count">
                                                    <label for="ct_qty_11" class="sound_only">수량</label>
                                                    <button type="button" class="sit_qty_minus"><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">감소</span></button>
                                                    <input type="text" name="ct_qty[{{ $item_info->item_code }}][]" value="1" id="ct_qty_11" class="num_input" size="5" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                    <button type="button" class="sit_qty_plus"><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">증가</span></button>
                                                    <span class="sit_opt_prc">+0원</span>
                                                </div>
                                            </li>
                                        </ul>

                                        <script>
                                            $(function() {
                                                price_calculate();
                                            });
                                        </script>
                                        @endif

                                    </section>
                                    <!-- } 선택된 옵션 끝 -->

                                    <!-- 총 구매액 -->
                                    <div id="sit_tot_price"></div>

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <button type="button" onclick="fitem_submit('cart');">장바구니22222</button>
                                    <button type="button" onclick="fitem_submit('buy');">바로구매</button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @endif

            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table border=1>
                <tr>
                    <td>상품정보</td>
                </tr>
            </table>
        </td>
    </tr>
</form>
</table>



<script>
    function ajax_big_img_change(item_code, item_img){
        $.ajax({
            type: 'get',
            url: '{{ route('ajax_big_img_change') }}',
            dataType: 'text',
            data: {
                'item_code' : item_code,
                'item_img'  : item_img,
            },
            success: function(result) {
                $("#big_img").attr("src", result);
            },error: function(result) {
                console.log(result);
            }
        });
    }
</script>

<!--
<script>
jQuery(function($){
    var change_name = "ct_copy_qty";

    $(document).on("select_it_option_change", "select.it_option", function(e, $othis) {
        var value = $othis.val(),
            change_id = $othis.attr("id").replace("it_option_", "it_side_option_");

        if( $("#"+change_id).length ){
            $("#"+change_id).val(value).attr("selected", "selected");
        }
    });

    $(document).on("select_it_option_post", "select.it_option", function(e, $othis, idx, sel_count, data) {
        var value = $othis.val(),
            change_id = $othis.attr("id").replace("it_option_", "it_side_option_");

        $("select.it_side_option").eq(idx+1).empty().html(data).attr("disabled", false);

        // select의 옵션이 변경됐을 경우 하위 옵션 disabled
        if( (idx+1) < sel_count) {
            $("select.it_side_option:gt("+(idx+1)+")").val("").attr("disabled", true);
        }
    });

    $(document).on("add_sit_sel_option", "#sit_sel_option", function(e, opt) {

        opt = opt.replace('name="ct_qty[', 'name="'+change_name+'[');

        var $opt = $(opt);
        $opt.removeClass("sit_opt_list");
        $("input[type=hidden]", $opt).remove();

        $(".sit_sel_option .sit_opt_added").append($opt);

    });

    $(document).on("price_calculate", "#sit_tot_price", function(e, total) {

        $(".sum_section .sit_tot_price").empty().html("<span>총 금액 </span><strong>"+number_format(String(total))+"</strong> 원");

    });

    $(".sit_side_option").on("change", "select.it_side_option", function(e) {
        var idx = $("select.it_side_option").index($(this)),
            value = $(this).val();

        if( value ){
            if (typeof(option_add) != "undefined"){
                option_add = true;
            }

            $("select.it_option").eq(idx).val(value).attr("selected", "selected").trigger("change");
        }
    });

    $(".sit_side_option").on("change", "select.it_side_supply", function(e) {
        var value = $(this).val();

        if( value ){
            if (typeof(supply_add) != "undefined"){
                supply_add = true;
            }

            $("select.it_supply").val(value).attr("selected", "selected").trigger("change");
        }
    });

    $(".sit_opt_added").on("click", "button", function(e){
        e.preventDefault();

        var $this = $(this),
            mode = $this.text(),
            $sit_sel_el = $("#sit_sel_option"),
            li_parent_index = $this.closest('li').index();

        if( ! $sit_sel_el.length ){
            alert("el 에러");
            return false;
        }

        switch(mode) {
            case "증가":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_qty_plus").trigger("click");
                break;
            case "감소":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_qty_minus").trigger("click");
                break;
            case "삭제":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_opt_del").trigger("click");
                break;
        }

    });

    $(document).on("sit_sel_option_success", "#sit_sel_option li button", function(e, $othis, mode, this_qty) {
        var ori_index = $othis.closest('li').index();

        switch(mode) {
            case "증가":
            case "감소":
                $(".sit_opt_added li").eq(ori_index).find("input[name^=ct_copy_qty]").val(this_qty);
                break;
            case "삭제":
                $(".sit_opt_added li").eq(ori_index).remove();
                break;
        }
    });

    $(document).on("change_option_qty", "input[name^=ct_qty]", function(e, $othis, val, force_val) {
        var $this = $(this),
            ori_index = $othis.closest('li').index(),
            this_val = force_val ? force_val : val;

        $(".sit_opt_added").find("li").eq(ori_index).find("input[name^="+change_name+"]").val(this_val);
    });

    $(".sit_opt_added").on("keyup paste", "input[name^="+change_name+"]", function(e) {
         var $this = $(this),
             val= $this.val(),
             this_index = $("input[name^="+change_name+"]").index(this);

         $("input[name^=ct_qty]").eq(this_index).val(val).trigger("keyup");
    });

    $(".sit_order_btn").on("click", "button", function(e){
        e.preventDefault();

        var $this = $(this);

        if( $this.hasClass("sit_btn_cart") ){
            $("#sit_ov_btn .sit_btn_cart").trigger("click");
        } else if ( $this.hasClass("sit_btn_buy") ) {
            $("#sit_ov_btn .sit_btn_buy").trigger("click");
        }
    });
});
</script>
-->

<script>
    // 바로구매, 장바구니 폼 전송
    function fitem_submit(type)
    {
        //$("#fitem").attr("action", "{{ route('ajax_cart_register') }}");
        //$("#fitem").attr('target', "");

        if (type == "cart") {   //장바구니
            $("#sw_direct").val(0);
        } else { // 바로구매
            $("#sw_direct").val(1);
        }

        // 판매가격이 0 보다 작다면
        var aa = 0;
        if( aa< 0){
            alert("전화로 문의해 주시면 감사하겠습니다.");
            return false;
        }

        if($(".sit_opt_list").length < 1) {
            alert("상품의 선택옵션을 선택해 주십시오.");
            return false;
        }

        var val, io_type, result = true;
        var sum_qty = 0;
        var $el_type = $("input[name^=sio_type]");

        $("input[name^=ct_qty]").each(function(index) {
            val = $(this).val();

            if(val.length < 1) {
                alert("수량을 입력해 주십시오.");
                result = false;
                return false;
            }

            if(val.replace(/[0-9]/g, "").length > 0) {
                alert("수량은 숫자로 입력해 주십시오.");
                result = false;
                return false;
            }

            if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
                alert("수량은 1이상 입력해 주십시오.");
                result = false;
                return false;
            }

            sio_type = $el_type.eq(index).val();

            if(sio_type == "0") sum_qty += parseInt(val);
        });

        if(!result) {
            return false;
        }

        //$("#fitem").submit();

        var queryString = $("form[name=fitem]").serialize() ;

        $.ajax({
            type : 'post',
            url : '{{ route('ajax_cart_register') }}',
            data : queryString,
            dataType : 'text',
            success : function(result){
//alert(result);

                if(result == "no_carts"){
                    alert("장바구니에 담을 상품을 선택하여 주십시오.");
                    return false;
                }

                if(result == "no_option"){
                    alert("상품의 선택옵션을 선택해 주십시오.");
                    return false;
                }

                if(result == "no_cnt"){
                    alert("수량은 1 이상 입력해 주십시오.");
                    return false;
                }

                if(result == "no_items"){
                    alert("상품정보가 존재하지 않습니다.");
                    return false;
                }

                if(result == "negative_price"){
                    alert("구매금액이 음수인 상품은 구매할 수 없습니다.");
                    return false;
                }

                if(result == "no_qty"){
                    alert("재고수량이 부족합니다.");
                    return false;
                }

                if(result == "yes_mem"){
                    //goto_url(G5_SHOP_URL."/orderform.php?sw_direct=$sw_direct");
                    location.href = "{{ route('orderform') }}";
                }

                if(result == "no_mem"){
                    //goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/orderform.php?sw_direct=$sw_direct"));
                    location.href = "";
                }

                if(result == "cart_page"){
                    location.href = "{{ route('cartlist') }}";
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>





@endsection
