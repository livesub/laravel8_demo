@extends('layouts.head')

@section('content')






<table border="1">
    <tr>
        <td><h4>상품</h4></td>
    </tr>
</table>




<table border=1>
    <tr>
        @foreach($cate_infos as $cate_info)

        @php
            //하위 카테고리가 없을때 링크 걸리지 않게
            $down_cate = DB::table('categorys')->where('ca_id','like',$cate_info->ca_id.'%')->count();   //하위 카테고리 갯수
        @endphp

        <td>
            @if($down_cate == 1)
            {{ $cate_info->ca_name_kr }}
            @else
            <a href="{{ route('item.index','ca_id='.$cate_info->ca_id) }}">{{ $cate_info->ca_name_kr }}</a>
            @endif

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
        <td>
            <table>
                <tr>
                    <td><img src=""></td>
                </tr>
                <tr>
                    <td>엔진오일</td>
                </tr>
            </table>
        </td>
            @endforeach
        @endif

<!--
        <td>
            <table>
                <tr>
                    <td><img src=""></td>
                </tr>
                <tr>
                    <td>엔진오일</td>
                </tr>
            </table>
        </td>

        <td>
            <table>
                <tr>
                    <td><img src=""></td>
                </tr>
                <tr>
                    <td>엔진오일</td>
                </tr>
            </table>
        </td>
-->
    </tr>
</table>








@endsection
