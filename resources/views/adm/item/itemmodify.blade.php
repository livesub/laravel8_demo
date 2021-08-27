@extends('layouts.admhead')

@section('content')


<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<script>
    function submitContents(elClickedObj) {
        oEditors.getById["item_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("item_content").value를 이용해서 처리하면 됩니다.
        var item_content = $("#item_content").val();

        if($("#last_choice_ca_id").val() == ""){
            alert("단계를 선택 하세요.");
            $("#caa_id").focus();
            return;
        }

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
        $("#item_form").attr("action", "{{ route('adm.item.modifysave') }}");
        $("#item_form").submit();
    }
</script>
<!-- smarteditor2 사용 -->



<table>
    <tr>
        <td><h4>상품 수정</h4></td>
    </tr>
</table>

<form name="item_form" id="item_form" method="post" action="{{ route('adm.item.modifysave') }}" enctype='multipart/form-data'>
{!! csrf_field() !!}
<input type="hidden" name="id" id="num" value="{{ $item_info->id }}">
<input type="hidden" name="ca_id" id="ca_id">
<input type="hidden" name="length" id="length">
<input type="hidden" name="last_choice_ca_id" id="last_choice_ca_id" value="{{ $item_info->ca_id }}">
<input type="hidden" name="item_code" id="item_code" value="{{ $item_info->item_code }}">


<table border=1 width="900px;">
    <tr>
        <td colspan=5>
            카테고리 선택
        </td>
    </tr>
    <tr>
        <td >
            <table>
                <tr>
                    <td>
                        <table id="cate1">
                        <tr>
                            <td>
                                <select size="10" name="ca_id" id="caa_id" class="cid" >
                                @foreach($one_step_infos as $one_step_info)
                                    @php
                                        if($one_str_cut == $one_step_info->ca_id) $one_selected = "selected";
                                        else $one_selected = "";
                                    @endphp

                                    <option value="{{ $one_step_info->ca_id }}" {{ $one_selected }}>{{ $one_step_info->ca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                        <tr>
                        </table>
                    </td>


                    <td>
                        <table id="cate2" style="display:block">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 4)
                            <td>
                                <select size="10" name="ca_id" id="caa_id2" class="cid" >
                                @foreach($two_step_infos as $two_step_info)
                                    @php
                                        if($two_str_cut == $two_step_info->ca_id) $two_selected = "selected";
                                        else $two_selected = "";
                                    @endphp

                                    <option value="{{ $two_step_info->ca_id }}" {{ $two_selected  }}>{{ $two_step_info->ca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>

                    <td>
                        <table id="cate3" style="display:block">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 6)
                            <td>
                                <select size="10" name="ca_id" id="caa_id3" class="cid" >
                                @foreach($three_step_infos as $three_step_info)
                                    @php
                                        if($three_str_cut == $three_step_info->ca_id) $three_selected = "selected";
                                        else $three_selected = "";
                                    @endphp

                                    <option value="{{ $three_step_info->ca_id }}" {{ $three_selected }}>{{ $three_step_info->ca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>

                    <td>
                        <table id="cate4" style="display:block">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 8)
                            <td>
                                <select size="10" name="ca_id" id="caa_id4" class="cid" >
                                @foreach($four_step_infos as $four_step_info)
                                    @php
                                        if($four_str_cut == $four_step_info->ca_id) $four_selected = "selected";
                                        else $four_selected = "";
                                    @endphp

                                    <option value="{{ $four_step_info->ca_id }}" {{ $four_selected }}>{{ $four_step_info->ca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>


                    <td>
                        <table id="cate5" style="display:block">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 10)
                            <td>
                                <select size="10" name="ca_id" id="caa_id5" class="cid" >
                                @foreach($five_step_infos as $five_step_info)
                                    @php
                                        if($five_str_cut == $five_step_info->ca_id) $five_selected = "selected";
                                        else $five_selected = "";
                                    @endphp

                                    <option value="{{ $five_step_info->ca_id }}" {{ $five_selected }}>{{ $five_step_info->ca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>

                </tr>
            </table>
        </td>
    </tr>

</table>



<table border=1 style="width:950px">
    <tr>
        <td>상품코드</td>
        <td>{{ $item_info->item_code }}</td>
    </tr>
    <tr>
        <td>상품명</td>
        <td><input type="text" name="item_name" id="item_name" value="{{ stripslashes($item_info->item_name) }}"></td>
    </tr>
    <tr>
        <td>출력여부</td>
        <td>
        @php
            $disp_yes = "";
            $disp_no = "";
            if($item_info->item_display == "Y"){
                $disp_yes = "checked";
                $disp_no = "";
            }else{
                $disp_yes = "";
                $disp_no = "checked";
            }
        @endphp
            <input type="radio" name="item_display" id="item_display_yes" value="Y" {{ $disp_yes }}>출력
            <input type="radio" name="item_display" id="item_display_no" value="N" {{ $disp_no }}>출력안함
        </td>
    </tr>
    <tr>
        <td>출력순서</td>
        <td><input type="text" name="item_rank" id="item_rank" maxlength="3" size="3" value="{{ $item_info->item_rank }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다.</td>
    </tr>
    <tr>
        <td>상품내용</td>
        <td>
            <textarea type="text" name="item_content" id="item_content" style="width:100%">{{ $item_info->item_content }}</textarea>
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
        <td>
            <input type="file" name="item_img" id="item_img">
            @error('item_img')
                <strong>{{ $message }}</strong>
            @enderror

                <br><a href="javascript:file_down('{{ $item_info->id }}','{{ $item_info->ca_id }}');">{{ $item_info->item_ori_img }}</a><br>
            <input type='checkbox' name="file_chk1" id="file_chk1" value='1'>수정,삭제,새로 등록시 체크 하세요.
        </td>
    </tr>
    <tr colspan="2">
        <td><button type="button" onclick="submitContents();">저장</button></td>
    </tr>

</table>
<form>


<script>
	$(document).ready(function() {
        $(document).on("click", "#caa_id", function() {
			var cate_is = $('#caa_id').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    type: 'post',
                    url: '{{ route('adm.cate.ajax_select') }}',
                    dataType: 'text',
                    data: {
                        'ca_id'   : $('#caa_id').val(),
                        'length'  : $('#caa_id').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
    //alert(data.ca_name_kr);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate2').css('display', 'block');
                            $('#cate2').html(data.data);
                            $('#cate3').html('');
                            $('#cate4').html('');
                            $('#cate5').html('');
                        }

                    },error: function(result) {
                        console.log(result);
                    }
                });
            }
		});

		$(document).on("click", "#caa_id2", function() {
			var cate_is = $('#caa_id2').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('adm.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id2').val(),
                        length  : $('#caa_id2').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate3').css('display', 'block');
                            $('#cate3').html(data.data);
                            $('#cate4').html('');
                            $('#cate5').html('');
                        }
                    },error: function(result) {
                        console.log(result);
                    }
                });
            }
		});

		$(document).on("click", "#caa_id3", function() {
			var cate_is = $('#caa_id3').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('adm.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id3').val(),
                        length  : $('#caa_id3').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate4').css('display', 'block');
                            $('#cate4').html(data.data);
                            $('#cate5').html('');
                        }
                    }
                });
            }
		});

		$(document).on("click", "#caa_id4", function() {
			var cate_is = $('#caa_id4').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('adm.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id4').val(),
                        length  : $('#caa_id4').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate5').css('display', 'block');
                            $('#cate5').html(data.data);
                        }
                    }
                });
            }
		});

		$(document).on("click", "#caa_id5", function() {
            var num = 0;
		    var cate_is = $('#caa_id5').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('adm.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id5').val(),
                        length  : $('#caa_id5').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
    //alert(data.ca_id);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            //$('#cate5').css('display', 'block');
                            //$('#cate5').html(data.data);
                        }
                    }
                });
            }
		});

    });
</script>


<script>
    function file_down(id, ca_id)
    {
        $("#num").val(id);
        $("#ca_id").val(ca_id);
        $("#item_form").attr("action", "{{ route('adm.item.downloadfile') }}");
        $("#item_form").submit();
    }
</script>







@endsection
