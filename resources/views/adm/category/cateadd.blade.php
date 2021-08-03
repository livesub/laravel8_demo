@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>카테고리 등록</h4></td>
    </tr>
</table>

<table>
    <tr>
        <td>카테고리 선택</td>
        <td>
            <select name="ca_id" id="ca_id" onchange="cate_choice();">
                <option value="">--1단계분류선택--</option>
            @foreach($cate_1_infos as $cate_1_info)
                @php
                    $selected = "";
                    if($ca_id != ""){
                        if($ca_id == $cate_1_info->ca_id) $selected = "selected";
                    }
                @endphp
                <option value="{{ $cate_1_info->ca_id }}" {{ $selected }}>{{ $cate_1_info->ca_name_kr }}</option>
            @endforeach
            </select>
        </td>
    </tr>
</table>

<table border=1>
<form name="addcate_form" id="addcate_form" method="post" action="{{ route('adm.cate.addcategorysave') }}">
{!! csrf_field() !!}
<input type="hidden" name="ca_id" id="ca_id" value="{{ $ca_id }}">
    <tr>
        <td>한글명</td>
        <td><input type="text" name="ca_name_kr" id="ca_name_kr"></td>
        <td>영문명</td>
        <td><input type="text" name="ca_name_en" id="ca_name_en"></td>
    </tr>
    <tr>
        <td>출력여부</td>
        <td>
            <input type="radio" name="ca_display" id="ca_display_yes" value="Y" checked>출력
            <input type="radio" name="ca_display" id="ca_display_no" value="N">출력안함
        </td>
        <td>출력순서</td>
        <td><input type="text" name="ca_rank" id="ca_rank" maxlength="3" size="3"  onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다. </td>
    </tr>
    <tr>
        <td colspan="6"><button type="button" onclick="add_cate();">카테고리 추가</button></td>
    </tr>
</form>
</table>


<script>
    function cate_choice(){
        var ca_id = $("#ca_id option:selected").val();
        location.href = "{{ route('adm.cate.addcategory') }}?ca_id="+ca_id;
    }
</script>

<script>
    function add_cate(){
        if($.trim($("#ca_name_kr").val()) == ""){
            alert("한글명을 입력 하세요.");
            $("#ca_name_kr").focus();
            return false;
        }

        $("#addcate_form").submit();
    }
</script>



@endsection
