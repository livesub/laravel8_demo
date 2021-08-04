@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>상품 리스트</h4></td>
    </tr>
</table>

<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.cate.create') }}'">상품등록</button></td>
    </tr>
</table>

@endsection
