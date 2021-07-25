@extends('layouts.admhead')

@section('content')

<table border=1>
    <tr>
        <td><h4>{{ $board_set_info->bm_tb_subject }} 글보기</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>카테고리명</td>
        <td>{{ $category_ment }}</td>
    </tr>
    <tr>
        <td>제목</td>
        <td>{{ stripslashes($board_info->bdt_subject) }}</td>
    </tr>
    <tr>
        <td>내용</td>
        <td>{!! $board_info->bdt_content !!}</td>
    </tr>


    @for($i = 1; $i <= $board_set_info->bm_file_num; $i++)
        @php
        $file_ori_name = "bdt_ori_file_name$i";
        @endphp
    <tr>
        <td>첨부파일{{ $i }}</td>
        <td><a href="javascript:file_down('{{ $tb_name}}','{{ $board_info->id }}','{{ $i }}');">{{ $board_info->$file_ori_name }}</a></td>
    </tr>
    @endfor


    <tr>
        <td>조회수</td>
        <td>{{ $board_info->bdt_hit }}</td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>{!! $reply_button !!}</td>
        <td>{!! $write_button !!}</td>
        <td>수정</td>
        <td>삭제</td>
        <td>목록</td>
    </tr>
</table>

<form name="down_form" id="down_form" method="post" action="{{ route('adm.admboard.downloadfile') }}">
{!! csrf_field() !!}
    <input type="hidden" name="tb_name" id="tb_name">
    <input type="hidden" name="b_id" id="b_id">
    <input type="hidden" name="file_num" id="file_num">
</form>


<script>
    function file_down(tb_name, b_id, file_num){
        $("#tb_name").val(tb_name);
        $("#b_id").val(b_id);
        $("#file_num").val(file_num);
        $("#down_form").submit();
    }
</script>

@endsection
