@extends('layouts.admhead')

@section('content')

<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<script>
    function submitContents(elClickedObj) {
        oEditors.getById["bdt_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("bdt_content").value를 이용해서 처리하면 됩니다.
        var bdt_content = $("#bdt_content").val();

        if($.trim($("#bdt_subject").val()) == ""){
            alert("제목을 입력하세요.");
            $("#bdt_subject").focus();
            return;
        }

        @if($user_level == 100)
        if($.trim($("#bdt_uname").val()) == ""){
            alert("글쓴이를 입력하세요.");
            $("#bdt_uname").focus();
            return;
        }

        if($.trim($("#bdt_upw").val()) == ""){
            alert("비밀번호를 입력하세요.");
            $("#bdt_upw").focus();
            return;
        }
        @endif

        if( bdt_content == ""  || bdt_content == null || bdt_content == '&nbsp;' || bdt_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["bdt_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}

        $("#boardForm").submit();
    }
</script>
<!-- smarteditor2 사용 -->
<table>
    <tr>
        <td>
            <h4>{{ $board_set_info->bm_tb_subject }} 글 수정</h4>
        <td>
    </tr>
</table>
<table border=1 width="800">
<form name="boardForm" id="boardForm" action="{{ route('adm.admboard.modifysave',$board_set_info->bm_tb_name) }}" method="POST" enctype='multipart/form-data'>
{!! csrf_field() !!}
<input type="hidden" name="bdt_uid" id="bdt_uid" value="{{ $user_id }}">
<input type="hidden" name="b_id" id="b_id" value="{{ $board_info->id }}">

    @if($board_set_info->bm_category_key != "")
    <tr>
        <td>카테고리</td>
        <td>{!! $select_disp !!}</td>
    </tr>
    @endif

    <tr>
        <td>제목</td>
        <td><input type="text" name="bdt_subject" id="bdt_subject" value="{{ stripslashes($board_info->bdt_subject) }}" maxlength="180"></td>
    </tr>


    @if($user_level == 100)
    <tr>
        <td>글쓴이</td>
        <td><input type="text" name="bdt_uname" id="bdt_uname" value="{{ $board_info->bdt_uname }}"></td>
    </tr>

    <tr>
        <td>비밀번호</td>
        <td>
            <input type="password" name="bdt_upw" id="bdt_upw"><br>
                @if ($user_level == config('app.ADMIN_LEVEL'))
                    ※ 관리자 수정시 비밀 번호는 변경 되지 않습니다.
                @endif
        </td>
    </tr>
    @endif

    @if($board_set_info->bm_secret_type == 1)

        @php
        if($board_info->bdt_chk_secret == 1){
            $disp = "block";
            $secret_chk_box = "checked";
        }else{
            $disp = "none";
            $secret_chk_box = "";
        }
        @endphp
    <tr>
        <td>비밀글</td>
        <td><input type="checkbox" name="bdt_chk_secret" id="bdt_chk_secret" value="1" onclick="secret_chk();" {{ $secret_chk_box }}></td>
    </tr>
    @endif


    <tr>
        <td>내용</td>
        <td>
            <textarea name="bdt_content" id="bdt_content" style="width:100%;height:220px;">{{ $board_info->bdt_content }}</textarea>
<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "bdt_content",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {fOnBeforeUnload : function(){}} // 이페이지 나오기 alert 삭제
    });
</script>
        </td>
    </tr>

    @for($i = 1; $i <= $board_set_info->bm_file_num; $i++)
    <tr>
        <td>첨부파일{{ $i }}</td>
        <td><input type="file" name="bdt_file{{ $i }}" id="bdt_file{{ $i }}">
        @error('bdt_file'.$i)
            <strong>{{ $message }}</strong>
        @enderror

        @php
            $file_ori_name = "bdt_ori_file_name$i";
        @endphp
            <br><a href="javascript:file_down('{{ $tb_name }}','{{ $board_info->id }}','{{ $i }}');">{{ $board_info->$file_ori_name }}</a><br>
            <input type='checkbox' name="file_chk{{ $i }}" id="file_chk{{ $i }}" value='1'>수정,삭제,새로 등록시 체크 하세요.
        </td>
    </tr>
    @endfor

    <tr colspan="2">
        <td><button type="button" onclick="submitContents();">저장</button></td>
        <td><button type="button" onclick="history.back(-1);">취소</button></td>
    </tr>
    </form>
</table>

<form name="down_form" id="down_form" method="post" action="{{ route('adm.admboard.downloadfile') }}">
{!! csrf_field() !!}
    <input type="hidden" name="tb_name" id="tb_name_down">
    <input type="hidden" name="b_id" id="b_id">
    <input type="hidden" name="file_num" id="file_num">
</form>


<script>
    function file_down(tb_name, b_id, file_num){
        $("#tb_name_down").val(tb_name);
        $("#b_id").val(b_id);
        $("#file_num").val(file_num);
        $("#down_form").submit();
    }
</script>

@endsection
