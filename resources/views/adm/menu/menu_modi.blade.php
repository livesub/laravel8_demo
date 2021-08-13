@extends('layouts.admhead')

@section('content')


<!-- smarteditor2 호출 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smarteditor2 호출 -->

<table>
    <tr>
        <td><h4>{{ $menu_info->menu_name_kr }} 수정</h4></td>
    </tr>
</table>

<form name="menu_modi_form" id="menu_modi_form" method="post" action="{{ route('adm.menu.modi_save') }}">
{!! csrf_field() !!}
<input type="hidden" name="id" id="id" value="{{ $menu_info->id }}">
<input type="hidden" name="menu_id" id="menu_id" value="{{ $menu_info->menu_id }}">
<input type="hidden" name="page" id="page" value="{{ $page }}">

<table border=1>
    <tr>
        <td>분류코드</td>
        <td colspan=3>{{ $menu_info->menu_id }}</td>
    </tr>
    <tr>
        <td>영문명</td>
        <td>
            <b>{{ $menu_info->menu_name_en }}</b>
        </td>

        <td>한글명</td>
        <td><input type="text" name="menu_name_kr" id="menu_name_kr" value="{{ $menu_info->menu_name_kr }}">
            @error('menu_name_kr')
                <strong>{{ $message }}</strong>
            @enderror
        </td>
    </tr>
    <tr>
        <td>출력여부</td>
        <td>
        @php
            $disp_yes = "";
            $disp_no = "";
            if($menu_info->menu_display == "Y"){
                $disp_yes = "checked";
                $disp_no = "";
            }else{
                $disp_yes = "";
                $disp_no = "checked";
            }
        @endphp
            <input type="radio" name="menu_display" id="menu_display_yes" value="Y" {{ $disp_yes }}>출력
            <input type="radio" name="menu_display" id="menu_display_no" value="N" {{ $disp_no }}>출력안함
        </td>
        <td>출력순서</td>
        <td><input type="text" name="menu_rank" id="menu_rank" maxlength="3" size="3" value="{{ $menu_info->menu_rank }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다. </td>
    </tr>

    <tr>
        <td>페이지 타입</td>
        <td colspan="3">
        @php
            $page_disp_p = "";
            $page_disp_b = "";
            $page_disp_I = "";
            if($menu_info->menu_page_type == "P"){
                $page_disp_p = "checked";
                $page_disp_b = "";
                $page_disp_I = "";
            }elseif($menu_info->menu_page_type == "B"){
                $page_disp_p = "";
                $page_disp_b = "checked";
                $page_disp_I = "";
            }else{
                $page_disp_p = "";
                $page_disp_b = "";
                $page_disp_I = "checked";
            }
        @endphp
            <input type="radio" name="menu_page_type" id="menu_page_type_p" value="P" {{ $page_disp_p }}>일반 HTML 타입
            <input type="radio" name="menu_page_type" id="menu_page_type_b" value="B" {{ $page_disp_b }}> 게시판 타입
            <input type="radio" name="menu_page_type" id="menu_page_type_I" value="I" {{ $page_disp_I }}> 상품 타입
        </td>
    </tr>
    <tr>
        <td>내용</td>
        <td colspan=3>
            <textarea name="menu_content" id="menu_content" style="width:100%;height:220px;">{{ $menu_info->menu_content }}</textarea>
<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "menu_content",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {fOnBeforeUnload : function(){}} // 이페이지 나오기 alert 삭제
    });
</script>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td><button type="button" onclick="add_menu();">메뉴 수정</button></td>
    </tr>
</table>
</form>


<script type="text/javascript">
    $(document).ready(function(){
    //한글입력 안되게 처리
        $("#menu_name_en").keyup(function(event){
            if (!(event.keyCode >=37 && event.keyCode<=40)) {
                var inputVal = $(this).val();
                $(this).val(inputVal.replace(/[^a-z0-9_]/gi,''));
            }
        });
    });
</script>

<script>
    function add_menu(elClickedObj) {
        oEditors.getById["menu_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("menu_content").value를 이용해서 처리하면 됩니다.
        var menu_content = $("#menu_content").val();

        if($("#menu_name_kr").val() == ""){
            alert("한글명을 입력 하세요.");
            $("#menu_name_kr").focus();
            return false;
        }

        if( menu_content == ""  || menu_content == null || menu_content == '&nbsp;' || menu_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["menu_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}

        $("#menu_modi_form").submit();
    }
</script>



@endsection
