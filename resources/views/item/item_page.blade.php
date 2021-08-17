@extends('layouts.head')

@section('content')






<table border="1">
    <tr>
        <td><h4>상품</h4></td>
    </tr>
</table>


<table border="1">
<form name="search_form" id="search_form" method="get" action="{{ route('item.index') }}">
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
            <a href="{{ route('item.index','ca_id='.$cate_info->ca_id) }}">{{ $cate_info->ca_name_kr }}</a>
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

            @foreach($item_infos as $item_info)
            @php
                if($item_info->item_img == "") {
                    $item_img_disp = "no_img";
                }else{
                    $item_img_cut = explode("@@",$item_info->item_img);

                    if(count($item_img_cut) == 1) $item_img = $item_img_cut[0];
                    else $item_img = $item_img_cut[2];

                    $item_img_disp = "/data/item/".$item_img;
                }
            @endphp

        <td>
            <table>
                <tr>
                    <td><img src="{{ $item_img_disp }}"></td>
                </tr>
                <tr>

                    <td>{!! preg_replace("@({$keyword})@iu", "<font color='red'>$1</font>", mb_substr(stripslashes($item_info->item_name), 0, 10)) !!}</td>
                </tr>
            </table>
        </td>

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
