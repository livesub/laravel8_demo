@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>카테고리 관리</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>번호</td>
        <td>분류 한글명</td>
        <td>분류 영문명</td>
        <td>분류</td>
        <td>출력여부</td>
        <td>출력순위</td>
        <td>수정/삭제</td>
    </tr>
    @foreach($cate_infos as $cate_info)
    <tr>
        <td>{{ $virtual_num-- }}</td>
        <td>{{ $cate_info->ca_name_kr }}</td>
        <td>{{ $cate_info->ca_name_en }}</td>
        <td>단계</td>
        <td>여부</td>
        <td>{{ $cate_info->ca_rank }}</td>
        <td><button type="">수정</button><button type="">삭제</button></td>
    </tr>
    @endforeach
</table>


<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.cate.addcategory') }}'">카테고리 등록</button></td>
    </tr>
</table>



<table>
    <tr>
        <td>
           {!! $pageList !!}
        </td>
    </tr>
</table>



@endsection
