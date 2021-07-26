@extends('layouts.admhead')

@section('content')

<table border=1>
    <tr>
        <td><h4>{{ $board_set_info->bm_tb_subject }} 글보기</h4></td>
    </tr>
</table>

<table border=1>


    @if($board_set_info->bm_category_key != "")
    <tr>
        <td>카테고리명</td>
        <td>{{ $category_ment }}</td>
    </tr>
    @endif


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
        <td><a href="javascript:file_down('{{ $tb_name }}','{{ $board_info->id }}','{{ $i }}');">{{ $board_info->$file_ori_name }}</a></td>
    </tr>
    @endfor


    <tr>
        <td>조회수</td>
        <td>{{ $board_info->bdt_hit }}</td>
    </tr>
</table>

@if($board_set_info->bm_coment_type == "1")
<table border=1>
<form name="comment_form" id="comment_form" method="post" action="{{ route('adm.admboard.commemtsave',$tb_name) }}">
{!! csrf_field() !!}
<input type="hidden" name="page" id="c_page" value="{{ $page }}">
<input type="hidden" name="cate" id="c_cate" value="{{ $cate }}">
<input type="hidden" name="b_id" id="c_b_id" value="{{ $b_id }}">
    <tr>
        <td colspan="4"><h4>댓글쓰기</h4></td>
    </tr>

    @foreach($comment_infos as $comment_info)
    <tr>
        <td>
            글쓴이 : {{ $comment_info->bdct_uname }}<br>
            내용 : {{ $comment_info->bdct_memo }}<br>
        </td>
        <td><button type="button">답글</button></td>
        <td><button type="button">수정</button></td>
        <td><button type="button">삭제</button></td>
    </tr>
    @endforeach


    <tr>
        <td colspan="4">
            <textarea name="bdct_memo" id="bdct_memo"></textarea><br>
            <button type="button" onclick="comment_chk();">저장</button>
        </td>
    </tr>
</form>
</table>
@endif

<table border=1>
    <tr>
        <td>{!! $reply_button !!}</td>
        <td>{!! $write_button !!}</td>
        <td>{!! $modi_button !!}</td>
        <td>{!! $del_button !!}</td>
        <td>{!! $list_button !!}</td>
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

<form name="del_form" id="del_form" method="post" action="{{ route('adm.admboard.deletesave',$tb_name) }}">
{!! csrf_field() !!}
    <input type="hidden" name="b_id" id="board_id" value="{{ $board_info->id }}">
    <input type="hidden" name="mode" id="mode" value="del">
</form>

<script>
    function b_del(){
        if (confirm("게시물을 삭제 하시겠습니까?") == true){    //확인
            $("#del_form").submit();
        }else{
            return;
        }
    }
</script>

<script>
    function comment_chk(){
        if($.trim($("#bdct_memo").val()) == ""){
            alert('댓글을 입력 하세요.');
            $("#bdct_memo").focus();
            return false;
        }

        $("#comment_form").submit();
    }
</script>
@endsection
