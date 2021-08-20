@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>메일발송 대상 회원 선택</h4><br><font color="red"><b>※ 발송 완료 메세지가 나올때 까지 기다리세요.</b></font></td>
    </tr>
</table>

<div style="width:100%; height:200px; overflow:auto">
<table border=1>
    <form name="mlist" id="mlist" method="post" action="{{ route('adm.admemail.send_ok') }}">
    {!! csrf_field() !!}
    <input type="hidden" name="email_id" id="email_id" value="{{ $email_id }}">
    <tr>
        <td>선택<br><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"></td>
        <td>이메일</td>
        <td>이름</td>
        <td>전회번호</td>
    </tr>

    @foreach($user_lists as $user_list)
    <tr>
        <td><input type="checkbox" name="chk_id[]" value="{{ $user_list->id }}" id="chk_id_{{ $user_list->id }}"></td>
        <td>{{ $user_list->user_id }}</td>
        <td>{{ $user_list->user_name }}</td>
        <td>{{ $user_list->user_phone }}</td>
    </tr>
    @endforeach

    <tr>
        <td colspan=5><button type="button" onclick="send_ok();">발송</button></td>
    </tr>
    </form>
</table>
</div>


<script>
    function all_checked(sw) {
        var f = document.mlist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }
</script>

<script>
    function send_ok(){
        var chk_count = 0;
        var f = document.mlist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("메일 발송할 회원을 한명 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 메일을 발송 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>








@endsection
