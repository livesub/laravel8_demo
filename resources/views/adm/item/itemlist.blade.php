@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>상품 리스트</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>선택<input type="checkbox" name="" id=""></td>
        <td>번호</td>
        <td>상품코드</td>
        <td>분류</td>
        <td>이미지</td>
        <td>상품명</td>
        <td>출력순서</td>
        <td>관리</td>
    </tr>
    <tr>
        <td><input type="checkbox" name="" id=""></td>
        <td>1</td>
        <td>상품코드</td>
        <td>기아 < 뭐 < 뭐 < 뭐 < 뭐</td>
        <td>이미지</td>
        <td>상품명</td>
        <td>출력순서</td>
        <td>
            <button type="">수정</button>
            <button type="">삭제</button>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.cate.create') }}'">상품등록</button></td>
    </tr>
</table>

@endsection
