@extends('layouts.admhead')

@section('content')

<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>

<table>
    <tr>
        <td><h4>이메일 내용 수정</h4></td>
    </tr>
</table>

<table border=1 width="800">
<form name="emailForm" id="emailForm" action="{{ route('adm.admemail.modifysave') }}" method="POST" enctype='multipart/form-data'>
{!! csrf_field() !!}
    <input type="hidden" name="type_name" id="type_name">
    <input type="hidden" name="email_id" id="email_id" value="{{ $email_info->id }}">
    <input type="hidden" name="file_num" id="file_num">

    <tr>
        <td>이메일 제목</td>
        <td><input type="text" name="email_subject" id="email_subject" value="{{ stripslashes($email_info->email_subject) }}"></td>
    </tr>

    <tr>
        <td>이메일 내용</td>
        <td>
            <textarea name="email_content" id="email_content" style="width:100%;height:220px;">{{ $email_info->email_content }}</textarea>
<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "email_content",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {fOnBeforeUnload : function(){}} // 이페이지 나오기 alert 삭제
    });
</script>
        </td>
    </tr>

    @for($i = 1; $i <= 2; $i++)
    <tr>
        <td>첨부파일{{ $i }}</td>
        <td>
            <input type="file" name="email_file{{ $i }}" id="email_file{{ $i }}">
            @error('email_file'.$i)
                <strong>{{ $message }}</strong>
            @enderror
        @php
            $email_ori_file = "email_ori_file$i";
        @endphp
            <br><a href="javascript:file_down('email','{{ $email_info->id }}','{{ $i }}');">{{ $email_info->$email_ori_file }}</a><br>
            <input type='checkbox' name="file_chk{{ $i }}" id="file_chk{{ $i }}" value='1'>수정,삭제,새로 등록시 체크 하세요.
        </td>
    </tr>
    @endfor


    <tr>
        <td colspan="10"><button type="button" onclick="modi_email()">메일 내용 수정</button></td>
    </tr>
</form>
</table>




<script>
    function modi_email(elClickedObj) {
        oEditors.getById["email_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("email_content").value를 이용해서 처리하면 됩니다.
        var email_content = $("#email_content").val();

        if($.trim($("#email_subject").val()) == ""){
            alert("제목을 입력하세요.");
            $("#email_subject").focus();
            return;
        }

        if(email_content == ""  || email_content == null || email_content == '&nbsp;' || email_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["email_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}

        $("#emailForm").attr("action", "{{ route('adm.admemail.modifysave') }}");
        $("#emailForm").submit();
    }
</script>


<script>
    function file_down(type_name, email_id, file_num){
        $("#type_name").val(type_name);
        $("#email_id").val(email_id);
        $("#file_num").val(file_num);
        $("#emailForm").attr("action", "{{ route('adm.admemail.downloadfile') }}");
        $("#emailForm").submit();
    }
</script>




@endsection
