@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>1단계 메뉴 등록</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>영문명</td>
        <td>
            <input type="text" name="menu_name_en" id="menu_name_en">
            <br>※ 게시판 타입일 경우 게시판명을 입력 하세요.
        </td>

        <td>한글명</td>
        <td><input type="text" name="menu_name_kr" id="menu_name_kr"></td>
    </tr>
    <tr>
        <td>출력여부</td>
        <td>
            <input type="radio" name="menu_display" id="menu_display_yes" value="Y" checked>출력
            <input type="radio" name="menu_display" id="menu_display_no" value="N">출력안함
        </td>
        <td>출력순서</td>
        <td><input type="text" name="menu_rank" id="menu_rank" maxlength="3" size="3"  onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다. </td>
    </tr>

    <tr>
        <td>페이지 타입</td>
        <td colspan="3">
            <input type="radio" name="menu_page_type" id="menu_page_type_p" value="P" checked>일반 HTML 타입
            <input type="radio" name="menu_page_type" id="menu_page_type_b" value="B"> 게시판 타입
        </td>
    </tr>

</table>

<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.menu.create') }}'">메뉴 등록</button></td>
    </tr>
</table>







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





@endsection
