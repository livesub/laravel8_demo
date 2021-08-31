@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>{{ $sca_name_kr }} 하위 분류 추가</h4></td>
    </tr>
</table>


<table border=1>
    <tr>
        <td>분류 코드</td>
        <td>{{ $mk_sca_id }}</td>
    </tr>
</table>

<table border=1>
<form name="cate_add_form" id="cate_add_form" method="post" action="{{ route('shop.cate.cate_add_save') }}">
{!! csrf_field() !!}
<input type="hidden" name="mk_sca_id" id="mk_sca_id" value="{{ $mk_sca_id }}">
<input type="hidden" name="page" id="page" value="{{ $page }}">
    <tr>
        <td>한글명</td>
        <td><input type="text" name="sca_name_kr" id="sca_name_kr"></td>
        <td>영문명</td>
        <td><input type="text" name="sca_name_en" id="sca_name_en"></td>
    </tr>
    <tr>
        <td>출력여부</td>
        <td>
            <input type="radio" name="sca_display" id="sca_display_yes" value="Y" checked>출력
            <input type="radio" name="sca_display" id="sca_display_no" value="N">출력안함
        </td>
        <td>출력순서</td>
        <td><input type="text" name="sca_rank" id="sca_rank" maxlength="3" size="3"  onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다. </td>
    </tr>
    <tr>
        <td colspan="6"><button type="button" onclick="add_cate();">카테고리 추가</button></td>
    </tr>
</form>
</table>

<script>
    function add_cate(){
        if($.trim($("#sca_name_kr").val()) == ""){
            alert("한글명을 입력 하세요.");
            $("#sca_name_kr").focus();
            return false;
        }

        $("#cate_add_form").submit();
    }
</script>



@endsection
