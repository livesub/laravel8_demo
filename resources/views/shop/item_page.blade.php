@extends('layouts.shophead')

@section('content')


<table border="1">
    <tr>
        <td><h4>상품</h4></td>
    </tr>
</table>


<table border="1">
<form name="search_form" id="search_form" method="get" action="{{ route('sitem') }}">
<input type="hidden" name="ca_id" id="ca_id" value="{{ $ca_id }}">
<input type="hidden" name="page" id="page" value="{{ $pageNum }}">

    <tr>
        <td>
        @php
            if($keymethod == "item_name" || $keymethod == "")
            {
                $item_name_selected = "selected";
                $item_code_selected = "";
            }else{
                $item_name_selected = "";
                $item_code_selected = "selected";
            }
        @endphp
            <select name="keymethod" id="keymethod">
                <option value="item_name" {{ $item_name_selected }}>상품명</option>
                <option value="item_code" {{ $item_code_selected }}>상품코드</option>
            </select>
        </td>
        <td>
            <input type="text" name="keyword" id="keyword" value="{{ $keyword }}">
        </td>
        <td>
            <button type="button" onclick="search_chk();">검색</button>
        </td>
    </tr>
</form>
</table>



<table border=1>
    <tr>
        @foreach($cate_infos as $cate_info)
        <td>
            <a href="{{ route('sitem','ca_id='.$cate_info->sca_id) }}">{{ $cate_info->sca_name_kr }}</a>
        </td>
        @endforeach

    </tr>
</table>


<table border=1>
    <tr>
        @if(count($item_infos) == 0)

        <td>
            상품이 없습니다
        </td>

        @else
            @php
                $tr_num = 0;
            @endphp

            @foreach($item_infos as $item_info)
            @php
                if($item_info->item_img1 == "") {
                    $item_img_disp = asset("img/no_img.jpg");
                }else{
                    $item_img_cut = explode("@@",$item_info->item_img1);

                    if(count($item_img_cut) == 1) $item_img = $item_img_cut[0];
                    else $item_img = $item_img_cut[2];

                    $item_img_disp = "/data/shopitem/".$item_img;
                }
            @endphp

        <td style="width:300px;">
            <table>
                <tr>
                    <td><a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}"><img src="{{ $item_img_disp }}" style="width:300px;height:300px;"></a></td>
                </tr>
                <tr>
                    <td><a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}">{!! preg_replace("@({$keyword})@iu", "<font color='red'>$1</font>", mb_substr(stripslashes($item_info->item_name), 0, 10)) !!}</a></td>
                </tr>
                <tr>
                    <td>{!! preg_replace("@({$keyword})@iu", "<font color='red'>$1</font>", mb_substr(stripslashes($item_info->item_basic), 0, 70)) !!}</td>
                </tr>
                <tr>
                    <td>판매가격 : {{ $CustomUtils->display_price($item_info->item_price, $item_info->item_tel_inq) }}</td>
                </tr>

                @if($item_info->item_cust_price != 0)
                <tr>
                    <td>시중가격 : {{ $CustomUtils->display_price($item_info->item_cust_price) }}</td>
                </tr>
                @endif
                <!-- 히트,인기상품 아이콘 표시 -->
                {!! $CustomUtils->item_icon($item_info) !!}
            </table>
        </td>
                @php
                    $tr_num++;
                    if($tr_num % 4 == 0){
                        echo "</tr><tr>";
                    }
                @endphp

            @endforeach
        @endif
    </tr>
</table>


<table>
    <tr>
        <td>
           {!! $pageList !!}
        </td>
    </tr>
</table>


<script>
    function search_chk(){
        if($.trim($("#keyword").val()) == ""){
            alert("검색어를 입력 하세요.");
            $("#keyword").focus();
            return false;
        }
        $("#search_form").submit();
    }
</script>



@endsection
