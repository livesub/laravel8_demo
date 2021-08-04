@extends('layouts.admhead')

@section('content')


<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<script>
    function submitContents(elClickedObj) {
        oEditors.getById["item_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("item_content").value를 이용해서 처리하면 됩니다.
        var item_content = $("#item_content").val();

        if($.trim($("#item_name").val()) == ""){
            alert("상품명을 입력하세요.");
            $("#item_name").focus();
            return;
        }

        if( item_content == ""  || item_content == null || item_content == '&nbsp;' || item_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["item_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}

        $("#boardForm").submit();
    }
</script>
<!-- smarteditor2 사용 -->



<table>
    <tr>
        <td><h4>상품 등록</h4></td>
    </tr>
</table>


<table border=1>
    <tr>
        <td>
            카테고리 선택
        </td>
    </tr>
    <tr>
        <td  id="cate1">
            <table>
                <tr>

                    <td>
                    <div >
                        <select size="15" name="ca_id" id="caa_id" class="cid" >
                        @foreach($one_step_infos as $one_step_info)
                            <option value="{{ $one_step_info->ca_id }}">{{ $one_step_info->ca_name_kr }}</option>
                        @endforeach
                        </select>
                    </div>
                    </td>
                </tr>
            </table>
        </td>

        <td id="cate2" style="display:none">
            <table>
                <tr>
                    <div  >
                    @if($ca_id && strlen($ca_id) >= 4){
                    <td>
                        <select size="15" name="ca_id" id="caa_id" class="cid" >
                        @foreach($one_step_infos as $one_step_info)
                            <option value="{{ $one_step_info->ca_id }}">{{ $one_step_info->ca_name_kr }}</option>
                        @endforeach
                        </select>
                    </td>
                    </div>
                    @endif
                </tr>
            </table>
        </td>







    </tr>

</table>



<table border=1 style="width:950px">
    <tr>
        <td>상품코드</td>
        <td>{{ $item_code }}</td>
    </tr>
    <tr>
        <td>상품명</td>
        <td><input type="text" name="item_name" id="item_name"></td>
    </tr>
    <tr>
        <td>출력여부</td>
        <td>
            <input type="radio" name="item_display" id="item_display_yes" value="Y" checked>출력
            <input type="radio" name="item_display" id="item_display_no" value="N">출력안함
        </td>
    </tr>
    <tr>
        <td>출력순서</td>
        <td><input type="text" name="item_rank" id="item_rank" maxlength="3" size="3"  onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다.</td>
    </tr>
    <tr>
        <td>상품내용</td>
        <td>
            <textarea type="text" name="item_content" id="item_content" style="width:100%"></textarea>
<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "item_content",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {fOnBeforeUnload : function(){}} // 이페이지 나오기 alert 삭제
    });
</script>
        </td>
    </tr>
    <tr>
        <td>상품 이미지</td>
        <td><input type="file" name="" id=""></td>
    </tr>
    <tr colspan="2">
        <td><button type="button" onclick="submitContents();">저장</button></td>
    </tr>
</table>

<button type="button" onclick="aa()">BBBBBBBBB</button>
<script>
function aa(){
    $("#ca_id").val(10);
    $("#length").val(2);
    $("#test").submit();
}
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<!--
<form name="test" id="test" method="post" action="{{ route('adm.cate.ajax_select') }}">
<input type="hidden" name="ca_id" id="ca_id">
<input type="hidden" name="length" id="length">
{!! csrf_field() !!}
</form>
-->





<script>
	$(document).ready(function() {
		$(document).on("click", "#caa_id", function() {
			var company_is = $('#caa_id').val();
			$.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{ route('adm.cate.ajax_select') }}',
                dataType: 'text',
                data: {
                    'ca_id'   : $('#caa_id').val(),
                    'length'  : $('#caa_id').val().length
                },
				success: function(result) {
                    var data = JSON.parse(result);
					if(data.success == 0) {
						console.log(data.msg);
					}else{
						$('#cate2').css('display', 'block');
						$('#cate2').html(data.data);
						$('#cate3').html('');
						$('#cate4').html('');
					}

				},error: function(result) {
                    console.log(result);
                }
			});
		});

    });
</script>









@endsection
