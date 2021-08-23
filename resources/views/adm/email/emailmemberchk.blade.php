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
            //메일 발송중 이미지 띄우기
            LoadingWithMask('/img/loading.gif');
            setTimeout("closeLoadingWithMask()", 300000);

            //f.submit();
        }else{
            return;
        }
    }
</script>


<style>
    #loadingImg {
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        position: fixed;
        display: block;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
        text-align: center;
    }

    #loading-image {
        position: absolute;
        top: 100%;
        left: 50%;
        z-index: 100;
    }
</style>


<script>
    function LoadingWithMask(gif) {
        //화면의 높이와 너비를 구합니다.
        var maskHeight = $(document).height();
        var maskWidth  = window.document.body.clientWidth;
        var imgHeight = maskHeight / 3;
        var imgWidth = maskWidth / 2;

        //화면에 출력할 마스크를 설정해줍니다.
        var mask       = "<div id='mask' style='position:absolute; z-index:100; background-color:#000000; display:none; left:0; top:0;'></div>";
        var loadingImg = '';

        loadingImg += "<div id='loadingImg' style='width:"+imgWidth+"px;height:"+imgHeight+"px; text-align: center'>";
        loadingImg += " <img src='"+gif+"' id='loading-image' style='position: relative; display: block; margin: 0px auto;'/>";
        loadingImg += "</div>";

        //화면에 레이어 추가
        $('body').append(mask).append(loadingImg)

        //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채웁니다.
        $('#mask').css({
                'width' : maskWidth
                , 'height': maskHeight
                , 'opacity' : '0.3'
        });

        //마스크 표시
        $('#mask').show();

        //로딩중 이미지 표시
        $('#loadingImg').show();
    }
</script>







@endsection
