@extends('layouts.admhead')

@section('content')


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
            <input type="text" name="menu_name_en" id="menu_name_en" value="{{ $menu_info->menu_name_en }}">
            @error('menu_name_en')
                <strong>{{ $message }}</strong>
            @enderror
            <br>※ 게시판 타입일 경우 게시판명을 입력 하세요.
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
            if($menu_info->menu_page_type == "P"){
                $page_disp_p = "checked";
                $page_disp_b = "";
            }else{
                $page_disp_p = "";
                $page_disp_b = "checked";
            }
        @endphp
            <input type="radio" name="menu_page_type" id="menu_page_type_p" value="P" {{ $page_disp_p }}>일반 HTML 타입
            <input type="radio" name="menu_page_type" id="menu_page_type_b" value="B" {{ $page_disp_b }}> 게시판 타입
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
    function add_menu(){
        if($("#menu_name_en").val() == ""){
            alert("영문명을 입력 하세요.");
            $("#menu_name_en").focus();
            return false;
        }

        if($("#menu_name_kr").val() == ""){
            alert("한글명을 입력 하세요.");
            $("#menu_name_kr").focus();
            return false;
        }

        $("#menu_modi_form").submit();
    }
</script>



@endsection
