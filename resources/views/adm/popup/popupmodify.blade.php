@extends('layouts.admhead')

@section('content')

<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('/datepicker/dist/css/datepicker.min.css') }}">
<script src="{{ asset('/datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/datepicker/dist/js/i18n/datepicker.ko.js') }}"></script>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .double div {
        float: left;
    }
</style>
<!-- datepicker -->

<!-- smarteditor2 사용 -->
<script type="text/javascript" src="{{ asset('/smarteditor2/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
<!-- smarteditor2 사용 -->

<table>
    <tr>
        <td><h4>팝업 관리 수정</h4></td>
    </tr>
</table>

<table border=1>
<form name="pop_modi_form" id="pop_modi_form" method="post" action="{{ route('adm.pop.modifysave') }}">
{!! csrf_field() !!}
<input type="hidden" name="num" id="num" value="{{ $popup_info->id }}">
<input type="hidden" name="page" id="page" value="{{ $page }}">

    <tr>
        <td>시간</td>
        <td><input type="text" name="pop_disable_hours" id="pop_disable_hours" size="3" value="{{ $popup_info->pop_disable_hours }}">시간
        <br>※고객이 다시 보지 않음을 선택할 시 몇 시간동안 팝업레이어를 보여주지 않을지 설정합니다.</td>
    </tr>
    <tr>
        <td>시작일시</td>
        <td><input type="text" name="pop_start_time" id="pop_start_time" value="{{ $popup_info->pop_start_time }}" readonly></td>
    </tr>
    <tr>
        <td>종료일시</td>
        <td><input type="text" name="pop_end_time" id="pop_end_time" value="{{ $popup_info->pop_end_time }}" readonly>
        <br>※기본 오늘 날짜의 7일 후로
        </td>
    </tr>
    <tr>
        <td>팝업레이어 좌측 위치</td>
        <td><input type="text" name="pop_left" id="pop_left" size="3" maxlength="3" value="{{ $popup_info->pop_left }}">px</td>
    </tr>
    <tr>
        <td>팝업레이어 상단 위치</td>
        <td><input type="text" name="pop_top" id="pop_top" size="3" maxlength="3" value="{{ $popup_info->pop_top }}">px</td>
    </tr>
    <tr>
        <td>팝업레이어 넓이</td>
        <td><input type="text" name="pop_width" id="pop_width" size="3" maxlength="3" value="{{ $popup_info->pop_width }}">px</td>
    </tr>
    <tr>
        <td>팝업레이어 높이</td>
        <td><input type="text" name="pop_height" id="pop_height" size="3" maxlength="3" value="{{ $popup_info->pop_height }}">px</td>
    </tr>
    <tr>
        <td>팝업 제목</td>
        <td><input type="text" name="pop_subject" id="pop_subject" value="{{ stripslashes($popup_info->pop_subject) }}"></td>
    </tr>
    <tr>
        <td>팝업 내용</td>
        <td><textarea name="pop_content" id="pop_content">{{ $popup_info->pop_content }}</textarea></td>
    </tr>
    <tr>
        <td>출력 유무</td>
        <td>
        @php
            if($popup_info->pop_display == "Y"){
                $pop_display_yes = "checked";
                $pop_display_no = "";
            }else{
                $pop_display_yes = "";
                $pop_display_no = "checked";
            }
        @endphp
            <input type="radio" name="pop_display" id="pop_display_yes" value="Y" {{ $pop_display_yes }}>출력
            <input type="radio" name="pop_display" id="pop_display_no" value="N" {{ $pop_display_no }}>출력안함
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <button type="button" onclick="pop_modi()">수정</button>
        </td>
    </tr>
</form>
</table>


<script>
    //두개짜리 제어 연결된거 만들어주는 함수
    datePickerSet($("#pop_start_time"), $("#pop_end_time"), true); //다중은 시작하는 달력 먼저, 끝달력 2번째

    function datePickerSet(sDate, eDate, flag) {
        if (!isValidStr(sDate) && !isValidStr(eDate) && sDate.length > 0 && eDate.length > 0) {
            var sDay = sDate.val();
            var eDay = eDate.val();

            if (flag && !isValidStr(sDay) && !isValidStr(eDay)) { //처음 입력 날짜 설정, update...
                var sdp = sDate.datepicker().data("datepicker");
                sdp.selectDate(new Date(sDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요

                var edp = eDate.datepicker().data("datepicker");
                edp.selectDate(new Date(eDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요
            }

            //시작일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(eDay)) {
                sDate.datepicker({
                    maxDate: new Date(eDay.replace(/-/g, "/"))
                });
            }
            sDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });

            //종료일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(sDay)) {
                eDate.datepicker({
                    minDate: new Date(sDay.replace(/-/g, "/"))
                });
            }
            eDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });
        }

        function isValidStr(str) {
            if (str == null || str == undefined || str == "")
                return true;
            else
                return false;
        }
    }
</script>


<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "pop_content",
        sSkinURI: "{{ asset('/smarteditor2/SmartEditor2Skin.html') }}",
        fCreator: "createSEditor2",
        htParams : {fOnBeforeUnload : function(){}} // 이페이지 나오기 alert 삭제
    });
</script>


<script>
    function pop_modi(elClickedObj){
        oEditors.getById["pop_content"].exec("UPDATE_CONTENTS_FIELD", []);
        var pop_content = $("#pop_content").val();

        if($.trim($("#pop_subject").val()) == ""){
            alert("제목을 입력 하세요.");
            $("#pop_subject").focus();
            return false;
        }

        if( pop_content == ""  || pop_content == null || pop_content == '&nbsp;' || pop_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["pop_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            $("#pop_modi_form").submit();
        } catch(e) {}
    }
</script>






@endsection
