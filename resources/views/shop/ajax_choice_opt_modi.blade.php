
@if($option_1)
<form name="foption" method="post" action="" onsubmit="return formcheck(this);">
{!! csrf_field() !!}
<input type="hidden" name="act" value="optionmod">
<input type="hidden" name="item_code[]" value="{{ $item->item_code }}">
<input type="hidden" id="item_price" value="{{ $price->sct_price }}">
<input type="hidden" name="sct_send_cost" value="{{ $price->sct_send_cost }}">
<input type="hidden" name="sw_direct">
<table  class="sit_option">
    <tr>
        <td>
            <section class="option_wr">
                <h3>선택옵션</h3>
                {!! $option_1 !!}
            </section>
        </td>
    </tr>
</table>
@endif

@if($option_2)
<table  class="sit_option">
    <tr>
        <td>
            <section class="option_wr">
                <h3>추가옵션</h3>
                {!! $option_2 !!}
            </section>
        </td>
    </tr>
</table>
@endif


<div id="sit_sel_option">
	<h3>선택옵션</h3>
    <ul id="sit_opt_added">
        @foreach($carts as $cart)
            @php
                $i = 0;
                if(!$cart->sio_id) $it_stock_qty = $CustomUtils->get_item_stock_qty($cart->item_code);
                else $it_stock_qty = $CustomUtils->get_option_stock_qty($cart->item_code, $cart->sio_id, $cart->sio_type);

                if($cart->sio_price < 0) $sio_price = '('.number_format($cart->sio_price).'원)';
                else $sio_price = '(+'.number_format($cart->sio_price).'원)';

                $cls = 'opt';
                if($cart->sio_type) $cls = 'spl';
            @endphp

        <li class="sit_{{ $cls }}_list">
            <input type="hidden" name="sio_type[{{ $item->item_code }}][]" value="{{ $cart->sio_type }}">
            <input type="hidden" name="sio_id[{{ $item->item_code }}][]" value="{{ $cart->sio_id }}">
            <input type="hidden" name="sio_value[{{ $item->item_code }}][]" value="{{ $cart->sct_option }}">
            <input type="hidden" class="sio_price" value="{{ $cart->sio_price }}">
            <input type="hidden" class="sio_stock" value="{{ $it_stock_qty }}">
            <div class="opt_name">
                <span class="sit_opt_subj">{{ $cart->sct_option }}</span>
            </div>
            <div class="opt_count">
                <button type="button" class="sit_qty_minus btn_frmline"><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">감소</span></button>
                <label for="ct_qty_{{ $i }}" class="sound_only">수량</label>
                <input type="text" name="ct_qty[{{ $item->item_code }}][]" value="{{ $cart->sct_qty }}" id="ct_qty_{{ $i }}" class="num_input" size="5">
                <button type="button" class="sit_qty_plus btn_frmline"><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">증가</span></button>
                <span class="sit_opt_prc">{{ $sio_price }}</span>
                <button type="button" class="sit_opt_del"><i class="fa fa-times" aria-hidden="true"></i><span class="sound_only">삭제</span></button>
            </div>

        </li>
            @php
                $i++;
            @endphp
        @endforeach

    </ul>
</div>

<div id="sit_tot_price"></div>

<div class="btn_confirm">
    <button type="button" onclick="formcheck();">확인</button>
    <button type="button" id="mod_option_close" class="btn_close"><i class="fa fa-times" aria-hidden="true"></i><span class="sound_only">닫기</span></button>
</div>


<script>
function formcheck(f)
{
    var val, sio_type, result = true;
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
        if(sio_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    var queryString = $("form[name=foption]").serialize() ;
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




    //return true;
}
</script>