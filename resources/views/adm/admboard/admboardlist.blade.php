@extends('layouts.admhead')

@section('content')



<table>
    <tr>
        <td>
            <h4>{{ $board_set_info->bm_tb_subject }}</h4>
        </td>
    </tr>
</table>
<table border=1>
    <tr>
        <td>선택<br><input type="checkbox" name="" id=""></td>
        <td>번호</td>
        <td>제목</td>
        <td>글쓴이</td>
        <td>조회수</td>
    </tr>
    @foreach($board_lists as $board_list)
    <tr>
        <td><input type="checkbox" name="" id=""></td>
        <td>번호</td>
        <td>제목</td>
        <td>글쓴이</td>
        <td>조회수</td>
    </tr>
    @endforeach

</table>
<table>
    <tr>
        {!! $list_button !!}
        {!! $choice_del_button !!}
    </tr>
</table>


@endsection
