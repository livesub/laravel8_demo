@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>{{ $categorys_info->ca_name_kr }} 수정</h4></td>
    </tr>
</table>


<table border=1>
    <tr>
        <td>분류 코드</td>
        <td>{{ $categorys_info->ca_id }}</td>
    </tr>
</table>

<table border=1>
<form name="cate_add_form" id="cate_add_form" method="post" action="{{ route('adm.cate.cate_modi_save') }}">
{!! csrf_field() !!}
<input type="hidden" name="id" id="id" value="{{ $categorys_info->id }}">
<input type="hidden" name="ca_id" id="ca_id" value="{{ $categorys_info->ca_id }}">
<input type="hidden" name="page" id="page" value="{{ $page }}">
    <tr>
        <td>한글명</td>
        <td><input type="text" name="ca_name_kr" id="ca_name_kr" value="{{ stripslashes($categorys_info->ca_name_kr) }}"></td>
        <td>영문명</td>
        <td><input type="text" name="ca_name_en" id="ca_name_en" value="{{ stripslashes($categorys_info->ca_name_en) }}"></td>
    </tr>
    <tr>
        <td>출력여부</td>
        <td>
        @php
            $disp_yes = "";
            $disp_no = "";
            if($categorys_info->ca_display == "Y"){
                $disp_yes = "checked";
                $disp_no = "";
            }else{
                $disp_yes = "";
                $disp_no = "checked";
            }
        @endphp
            <input type="radio" name="ca_display" id="ca_display_yes" value="Y" {{ $disp_yes }}>출력
            <input type="radio" name="ca_display" id="ca_display_no" value="N" {{ $disp_no }}>출력안함
        </td>
        <td>출력순서</td>
        <td><input type="text" name="ca_rank" id="ca_rank" maxlength="3" size="3" value="{{ $categorys_info->ca_rank }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다. </td>
    </tr>
    <tr>
        <td colspan="6"><button type="button" onclick="add_cate();">카테고리 수정</button></td>
    </tr>
</form>
</table>

<script>
    function add_cate(){
        if($.trim($("#ca_name_kr").val()) == ""){
            alert("한글명을 입력 하세요.");
            $("#ca_name_kr").focus();
            return false;
        }

        $("#cate_add_form").submit();
    }
</script>



@endsection
