@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>회원 이메일 발송 관리</h4></td>
    </tr>
</table>

<table border=1>
    <form name="elist" id="elist" method="post" action="{{ route('adm.admemail.choice_del') }}">
    {!! csrf_field() !!}
    <tr>
        <td>선택<br><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk"></td>
        <td>번호</td>
        <td>제목</td>
        <td>작성일</td>
        <td>발송인원</td>
        <td>확인인원</td>
        <td>발송실패</td>
        <td>관리</td>
    </tr>

    @foreach($email_lists as $email_list)
        @php
            $send_cnt = 0;
            $receive_cnt = 0;
            $send_fail_cnt = 0;
            $send_cnt = DB::table('email_sends')->where('email_id',$email_list->id)->count(); //발송 인원
            $send_fail_cnt = DB::table('email_sends')->where([['email_id',$email_list->id],['email_send_chk','N']])->count(); //발송 실패 인원
            $receive_cnt = DB::table('email_sends')->where([['email_id',$email_list->id],['email_receive_chk','Y']])->count(); //메일 확인 인원
        @endphp
    <tr>
        <td><input type="checkbox" name="chk_id[]" value="{{ $email_list->id }}" id="chk_id_{{ $email_list->id }}" class="selec_chk"></td>
        <td>{{ $virtual_num-- }}</td>
        <td><a href="{{ route('adm.admemail.modify','id='.$email_list->id) }}">{{ stripslashes($email_list->email_subject) }}</a></td>
        <td>{{ $email_list->created_at }}</td>
        <td>{{ $send_cnt }}</td>
        <td>{{ $receive_cnt }}</td>
        <td>{{ $send_fail_cnt }}</td>
        <td><button type="button" onclick="location.href='{{ route('adm.admemail.send_mem_chk','id='.$email_list->id) }}'">보내기</button></td>
    </tr>
    @endforeach
    </form>
</table>

<table>
    <tr>
        <td colspan=10>{!! $pageList !!}</td>
    <tr>
</table>

<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.admemail.create') }}'">메일 내용 추가</button></td>
        <td colspan="10"><button type="button" onclick="choice_del();">선택 삭제</button></td>
    </tr>
</table>

<script>
    function all_checked(sw) {
        var f = document.elist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }
</script>

<script>
    function choice_del(){
        var chk_count = 0;
        var f = document.elist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("삭제할 게시물을 하나 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 게시물을 삭제 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>



@endsection
