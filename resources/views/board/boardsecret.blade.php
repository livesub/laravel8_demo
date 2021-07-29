@extends('layouts.head')

@section('content')


<table border=1>
<form name="secret_form" id="secret_form" method="post" action="{{ route('board.secretpw') }}">
{!! csrf_field() !!}
<input type="hidden" name="tb_name" id="tb_name" value="{{ $tb_name }}">
<input type="hidden" name="b_id" id="b_id" value="{{ $b_id }}">
<input type="hidden" name="page" id="page" value="{{ $page }}">
<input type="hidden" name="cate" id="cate" value="{{ $cate }}">
<input type="hidden" name="mode" id="mode" value="{{ $mode }}">

    <tr>
        <td colspan="2"><h4>비밀글 비밀번호 확인<h4></td>
    </tr>
    <tr>
        <td><h4>비밀번호<h4></td>
        <td><input type="password" name="upw" id="upw"></td>
    </tr>
    <tr>
        <td colspan=2><button type="button" onclick="secret_pw_chk();">확인</button></td>
    </tr>
</form>
</table>


<script>
    function secret_pw_chk(){
        if($("#upw").val() == ""){
            alert("비밀번호를 입력 하세요.");
            $("#upw").focus();
            return false;
        }else{
            $("#secret_form").submit();
        }
    }
</script>



@endsection
