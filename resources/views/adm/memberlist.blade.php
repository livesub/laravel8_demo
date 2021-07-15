@extends('layouts.admhead')

@section('content')



<small><?= $totalCount ?>명의 회원이 있습니다.
<?= $pageNum ?>페이지 입니다.</small>

<table border=1>
    <h4>회원 리스트</h4>
    <form name="memlist" id="memlist" method="post" action="{{ route('adm.member.out') }}">
    {!! csrf_field() !!}
    <tr>
        <td><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk"></td>
        <td>번호</td>
        <td>이름</td>
        <td>아이디</td>
        <td>가입일</td>
        <td>전화번호</td>
        <td>탈퇴여부</td>
    </tr>
    @foreach($members as $member)
        @php
            $user_type = "";
            if($member->user_type == 'Y') $user_type = '탈퇴';
            else $user_type = '가입';
        @endphp
    <tr>
        <td><input type="checkbox" name="chk_id[]" value="{{ $member->id }}" id="chk_id_{{ $member->id }}" class="selec_chk"></td>
        <td>{{ $virtual_num-- }}</td>
        <td><a href="javascript:mem_regi('modi',{{ $member->id }});">{{ $member->user_name }}</a></td>
        <td>{{ $member->user_id }}</td>
        <td>{{ $member->created_at }}</td>
        <td>{{ $member->user_phone }}</td>
        <td>{{ $user_type }}</td>
    </tr>

    @endforeach

    </form>

</table>
<table>
    <tr>
        <td>
            <button style="margin-top:20px;" onclick="mem_regi('regi');">회원등록</button>
        </td>

        <td>
            <button style="margin-top:20px;" onclick="mem_out();">회원 선택 탈퇴/가입 처리</button>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>
           {!! $pageList !!}
        </td>
    </tr>
</table>

<form action="" id="mem_form" method="GET">
    <input type="hidden" name="mode" id="mode">
    <input type="hidden" name="num" id="num">
</form>

<script>
    function mem_regi(value, num=''){
        $("#mode").val(value);
        $("#num").val(num);
        $("#mem_form").attr("action", "member/member_regi");
        $("#mem_form")[0].submit();
    }
</script>

<script>
    function all_checked(sw) {
        var f = document.memlist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }

    function mem_out(){
        var chk_count = 0;
        var f = document.memlist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("탈퇴/가입 할 회원을 한명 이상 선택하세요.");
            return false;
        }
        if (confirm("탈퇴 회원은 가입 처리 되며, 가입자는 탈퇴 처리 됩니다.\n회원 정보는 삭제 되지 않습니다.\n선택 하신 회원을 탈퇴/가입 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>

@endsection
