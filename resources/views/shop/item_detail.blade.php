@extends('layouts.shophead')

@section('content')

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
            <table border=1>
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

                <tr>
                    <td>포인트</td>
                    <td><h4>stop!!!!!</h4></td>
                </tr>
                <tr>
                    <td>배송비결제</td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>선택옵션</td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="" id="">
                                        <option value="aa">aa</option>
                                        <option value="bb">bb</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="" id="">
                                        <option value="aa">aa</option>
                                        <option value="bb">bb</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>추가옵션</td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="" id="">
                                        <option value="aa""/data/shopitem/">aa</option>
                                        <option value="bb">bb</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="" id="">
                                        <option value="aa">aa</option>
                                        <option value="bb">bb</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>총 금액</td>
                            </tr>
                            <tr>
                                <td>
                                    <button type="button">장바구니</button>
                                    <button type="button">바로구매</button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
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



@endsection
