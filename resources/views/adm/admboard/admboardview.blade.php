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
<input type="hidden" name="bdct_memo_reply" id="bdct_memo_reply" value="">

<input type="hidden" name="c_id" id="c_id" value="">
<input type="hidden" name="bdct_grp" id="bdct_grp" value="">
<input type="hidden" name="bdct_sort" id="bdct_sort" value="">
<input type="hidden" name="bdct_depth" id="bdct_depth" value="">

    <tr>
        <td colspan="4"><h4>댓글쓰기</h4></td>
    </tr>

    @foreach($comment_infos as $comment_info)

    <tr>
        <td>
            @if ($comment_info->bdct_depth == 0)
                글쓴이 : {{ $comment_info->bdct_uname }}<br> 내용 : {{ $comment_info->bdct_memo }}<br>
            @else
                @for ($i=0; $i<$comment_info->bdct_depth; $i++)
                    &nbsp&nbsp
                @endfor
                └글쓴이 : {{ $comment_info->bdct_uname }}<br> 내용 : {{ $comment_info->bdct_memo }}<br>
            @endif
            <textarea id="save_comment_{{ $comment_info->id }}" style="display:none">{{ $comment_info->bdct_memo }}</textarea>
        </td>
        <td><button type="button" onclick="comment_box('{{ $comment_info->id }}', '{{ $comment_info->bdct_grp }}', '{{ $comment_info->bdct_sort }}', '{{ $comment_info->bdct_depth }}','reply'); return false;">답글</button></td>
        <td><button type="button" onclick="comment_box('{{ $comment_info->id }}', '{{ $comment_info->bdct_grp }}', '{{ $comment_info->bdct_sort }}', '{{ $comment_info->bdct_depth }}','modi'); return false;">수정</button></td>
        <td><button type="button">삭제</button></td>
    </tr>

    <tr id="comment_id{{ $comment_info->id }}">
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

<script>
    function comment_box(id, bdct_grp, bdct_sort, bdct_depth, type){
        var html;
        var comment_memo = $("#save_comment_"+id).val();
        html = '<tr>';
        html += '    <td colspan="4">';

        if(type == 'reply'){
            html += '        <textarea name="bdct_memo_reply" id="bdct_memo_reply'+id+'"></textarea><br>';
            html += '        <button type="button" onclick="comment_reply_chk('+id+','+bdct_grp+','+bdct_sort+','+bdct_depth+','+type+');">답글저장</button>';
        }else if(type == 'modi'){
            html += '        <textarea name="bdct_memo_reply" id="bdct_memo_reply'+id+'">'+comment_memo+'</textarea><br>';
            html += '        <button type="button" onclick="comment_reply_chk('+id+','+bdct_grp+','+bdct_sort+','+bdct_depth+','+type+');">답글수정</button>';
        }
        html += '    </td>';
        html += '</tr>';

        $("#comment_id"+id).html(html);
    }
</script>

<script>
    function comment_reply_chk(id, bdct_grp, bdct_sort, bdct_depth, type){
alert("svsvsd");
        if($.trim($("#bdct_memo_reply"+id).val()) == ""){
            alert('답글을 입력 하세요.');
            $("#bdct_memo_reply"+id).focus();
            return false;
        }

        $("#c_id").val(id);   //댓글 원본 번호

        if(type == 'reply'){
            $("#bdct_grp").val(bdct_grp);
            $("#bdct_sort").val(bdct_sort);
            $("#bdct_depth").val(bdct_depth);
            $("#bdct_memo_reply").val($("#bdct_memo_reply"+id).val());  //값이 넘어가지 않아 hidden에 담아 보냄
            $("#comment_form").attr("action", "{{ route('adm.admboard.commemtreplysave',$tb_name) }}");
        }else if(type == 'modi'){
            alert('수정일때 처리')
        }
        $("#comment_form").submit();
    }
</script>

<script>
    function comment_modi_box(id){
        var aa = $("#save_comment_"+id).val();
        var html;
        html = '<tr>';
        html += '    <td colspan="4">';
        html += '        <textarea name="bdct_memo_reply" id="bdct_memo_reply'+id+'">'+aa+'</textarea><br>';
        html += '        <button type="button" onclick="comment_reply_chk('+id+','+bdct_grp+','+bdct_sort+','+bdct_depth+');">답글수정</button>';
        html += '    </td>';
        html += '</tr>';

        $("#comment_id"+id).html(html);


//document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
    }
</script>
@endsection
