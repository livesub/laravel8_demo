@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>메뉴 리스트</h4></td>
    </tr>
</table>

<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.menu.create') }}'">메뉴 등록</button></td>
    </tr>
</table>

@endsection
