@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>회원 이메일 발송 관리</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>선택<br><input type="checkbox"></td>
        <td>번호</td>
        <td>내용</td>
        <td>작성일</td>
        <td>발송인원</td>
        <td>확인인원</td>
        <td>발송일</td>
        <td>관리</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>번호</td>
        <td>내용</td>
        <td>작성일</td>
        <td>발송인원</td>
        <td>확인인원</td>
        <td>발송일</td>
        <td><button type="">보내기</button></td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>번호</td>
        <td>내용</td>
        <td>작성일</td>
        <td>발송인원</td>
        <td>확인인원</td>
        <td>발송일</td>
        <td><button type="">보내기</button></td>
    </tr>
    <tr>
        <td colspan="10"><button type="button" onclick="location.href='{{ route('adm.admemail.create') }}'">메일 내용 추가</button></td>
    </tr>
</table>

<table>
    <tr>
        <td>{{ $pageList }}</td>
    </tr>
</table>



@endsection
