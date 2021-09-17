@extends('layouts.admhead')

@section('content')


<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smarteditor2 사용 -->


<table>
    <tr>
        <td><h4>쇼핑몰 상품 등록</h4></td>
    </tr>
</table>

<form name="item_form" id="item_form" method="post" action="{{ route('shop.item.createsave') }}" enctype='multipart/form-data'>
{!! csrf_field() !!}
<input type="hidden" name="sca_id" id="sca_id">
<input type="hidden" name="sca_name_kr" id="sca_name_kr">
<input type="hidden" name="length" id="length">
<input type="hidden" name="last_choice_ca_id" id="last_choice_ca_id">
<input type="hidden" name="item_code" id="item_code" value="{{ $item_code }}">

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
                                    <option value="{{ $one_step_info->sca_id }}">{{ $one_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                        <tr>
                        </table>
                    </td>


                    <td>
                        <table id="cate2" style="display:none">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 4)
                            <td>
                                <select size="10" name="ca_id" id="caa_id2" class="cid" >
                                @foreach($two_step_infos as $two_step_info)
                                    <option value="{{ $two_step_info->sca_id }}">{{ $two_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>

                    </td>

                    <td>

                        <table id="cate3" style="display:none">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 6)
                            <td>
                                <select size="10" name="ca_id" id="caa_id3" class="cid" >
                                @foreach($three_step_infos as $three_step_info)
                                    <option value="{{ $three_step_info->sca_id }}">{{ $three_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>

                    </td>

                    <td>
                        <table id="cate4" style="display:none">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 8)
                            <td>
                                <select size="10" name="ca_id" id="caa_id4" class="cid" >
                                @foreach($four_step_infos as $four_step_info)
                                    <option value="{{ $four_step_info->sca_id }}">{{ $four_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>


                    <td>
                        <table id="cate5" style="display:none">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 10)
                            <td>
                                <select size="10" name="ca_id" id="caa_id5" class="cid" >
                                @foreach($five_step_infos as $five_step_info)
                                    <option value="{{ $five_step_info->sca_id }}">{{ $five_step_info->sca_name_kr }}</option>
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
        <td>{{ $item_code }}</td>
    </tr>
    <tr>
        <td>상품명</td>
        <td><input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}"></td>
    </tr>
    <tr>
        <td>기본설명</td>
        <td><input type="text" name="item_basic" id="item_basic" value="{{ old('item_basic') }}"></td>
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
        <td><input type="text" name="item_rank" id="item_rank" maxlength="3" size="3" value="{{ old('item_rank') }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다.</td>
    </tr>
    <tr>
        <td>상품 유형</td>
        <td>
            <span class="frm_info">메인화면에 유형별로 출력할때 사용합니다.<br>이곳에 체크하게되면 상품리스트에서 유형별로 정렬할때 체크된 상품이 가장 먼저 출력됩니다.</span><br>
            <input type="checkbox" name="item_type1" value="1"  id="item_type1">
            <label for="item_type1">히트 </label>
            <input type="checkbox" name="item_type2" value="1"  id="item_type2">
            <label for="item_type2">신상품 </label>
            <input type="checkbox" name="item_type3" value="1"  id="item_type3">
            <label for="item_type3">인기 </label>
            <input type="checkbox" name="item_type4" value="1"  id="item_type4">
            <label for="item_type4">할인 </label>
        </td>
    </tr>

    <tr>
        <td>제조사</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_manufacture" id="item_manufacture" value="{{ old('item_manufacture') }}">
        </td>
    </tr>

    <tr>
        <td>원산지</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_origin" id="item_origin" value="{{ old('item_origin') }}">
        </td>
    </tr>

    <tr>
        <td>브랜드</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_brand" id="item_brand" value="{{ old('item_brand') }}">
        </td>
    </tr>

    <tr>
        <td>모델</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_model" id="item_model" value="{{ old('item_model') }}">
        </td>
    </tr>

    <tr>
        <td>전화문의</td>
        <td>상품 금액 대신 전화문의로 표시됩니다. <br>
            <input type="checkbox" name="item_tel_inq" value="1" id="item_tel_inq" > 예
        </td>
    </tr>

    <tr>
        <td>판매가능</td>
        <td>잠시 판매를 중단하거나 재고가 없을 경우에 체크를 해제해 놓으면 출력되지 않으며, 주문도 받지 않습니다. <br>
            <input type="checkbox" name="item_use" value="1" id="item_use" > 예
        </td>
    </tr>

    <tr>
        <td>쿠폰적용안함</td>
        <td>설정에 체크하시면 쿠폰 생성 때 상품 검색 결과에 노출되지 않습니다.. <br>
            <input type="checkbox" name="item_nocoupon" value="1" id="item_nocoupon" > 예
        </td>
    </tr>

    <tr>
        <td>상품내용</td>
        <td>
            <textarea type="text" name="item_content" id="item_content" style="width:100%">{{ old('item_content') }}</textarea>
        </td>
    </tr>

    <tr>
        <td>판매가격</td>
        <td><input type="text" name="item_price" id="item_price" value="{{ old('item_price') }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">원</td>
    </tr>

    <tr>
        <td>시중가격</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다.<br>
            <input type="text" name="item_cust_price" id="item_cust_price" value="{{ old('item_cust_price') }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">원
        </td>
    </tr>

    <tr>
        <td>포인트 유형</td>
        <td>포인트 유형을 설정할 수 있습니다. <br>비율로 설정했을 경우 설정 기준금액의 %비율로 포인트가 지급됩니다.<br>
            <select name="item_point_type" id="item_point_type">
                    <option value="0" selected="selected">설정금액</option>
                    <option value="1">판매가기준 설정비율</option>
                    <option value="2">구매가기준 설정비율</option>
                </select>
        </td>
    </tr>

    <tr>
        <td>포인트</td>
        <td>주문완료후 환경설정에서 설정한 주문완료 설정일 후 회원에게 부여하는 포인트입니다.<br>또, 포인트부여를 '아니오'로 설정한 경우 신용카드, 계좌이체로 주문하는 회원께는 부여하지 않습니다.<br>
            <input type="text" name="item_point" value="0" id="item_point" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
            <span id="item_point_unit">점</span>
        </td>
    </tr>

    <tr>
        <td>추가옵션상품 포인트</td>
        <td>상품의 추가옵션상품 구매에 일괄적으로 지급하는 포인트입니다. <br>0으로 설정하시면 구매포인트를 지급하지 않습니다.<br>
        주문완료후 환경설정에서 설정한 주문완료 설정일 후 회원에게 부여하는 포인트입니다.<br>
        또, 포인트부여를 '아니오'로 설정한 경우 신용카드, 계좌이체로 주문하는 회원께는 부여하지 않습니다.<br>
            <input type="text" name="item_supply_point" value="0" id="item_supply_point" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 점
        </td>
    </tr>

    <tr>
        <td>상품품절</td>
        <td>잠시 판매를 중단하거나 재고가 없을 경우에 체크해 놓으면 품절상품으로 표시됩니다.<br>
            <input type="checkbox" name="item_soldout" value="1" id="item_soldout" > 예
        </td>
    </tr>

    <tr>
        <td>재고수량</td>
        <td>주문관리에서 상품별 상태 변경에 따라 자동으로 재고를 가감합니다. <br>재고는 규격/색상별이 아닌, 상품별로만 관리됩니다.<br>재고수량을 0으로 설정하시면 품절상품으로 표시됩니다.<br>
            <input type="text" name="item_stock_qty" value="99999" id="item_stock_qty" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 개
        </td>
    </tr>

    <tr>
        <td>상품선택옵션</td>
        <td>옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다.<br> 옷을 예로 들어 [옵션1 : 사이즈 , 옵션1 항목 : XXL,XL,L,M,S] , [옵션2 : 색상 , 옵션2 항목 : 빨,파,노]<br><strong>옵션명과 옵션항목에 따옴표(', ")는 입력할 수 없습니다.</strong><br>
            <table border=1>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>옵션1
                                    <input type="text" name="opt1_subject" value="" id="opt1_subject" size="15">
                                </td>
                                <td>옵션1 항목
                                    <input type="text" name="opt1" value="" id="opt1" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td>옵션2
                                    <input type="text" name="opt2_subject" value="" id="opt2_subject" size="15">
                                </td>
                                <td>옵션2 항목
                                    <input type="text" name="opt2" value="" id="opt2" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td>옵션3
                                    <input type="text" name="opt3_subject" value="" id="opt3_subject" size="15">
                                </td>
                                <td>옵션1 항목
                                    <input type="text" name="opt3" value="" id="opt3" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><button type="button" id="option_table_create">옵션목록생성</button></td>
                            </tr>

                        </table>
                    </td>
                </tr>

                <tr id="sit_option_frm">
                    <!-- 옵션 조합 리스트 나오는 곳 -->
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>상품추가옵션</td>
        <td>옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다. <br>스마트폰을 예로 들어 [추가1 : 추가구성상품 , 추가1 항목 : 액정보호필름,케이스,충전기]<br>
        <strong>옵션명과 옵션항목에 따옴표(', ")는 입력할 수 없습니다.</strong><br>
            <table border=1>
                <tr id="sit_supply_frm">
                    <td>
                        <table>
                            <tr>
                                <td>추가1
                                    <input type="text" name="spl_subject[]" id="spl_subject_" value="" size="15">
                                </td>
                                <td>추가1 항목
                                    <input type="text" name="spl[]" id="spl_item_" value="" size="40">
                                </td>
                                @php
                                    $i = 0;
                                @endphp

                                @if($i > 0)
                                <td>
                                    <button type="button" id="del_supply_row">삭제</button>
                                </td>
                                @endif
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><button type="button" id="add_supply_row">옵션추가</button></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="button" id="supply_table_create">옵션목록생성</button></td>
                </tr>

                <tr id="sit_option_addfrm">
                    <!-- 추가 옵션 조합 리스트 나오는 곳 -->
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>배송비 유형</td>
        <td>
            <table>
                <tr>
                    <td colspan=3>쇼핑몰설정 > 배송비유형 설정보다 개별상품 배송비설정이 우선 적용됩니다. <br>배송비 유형을 선택하면 자동으로 항목이 변환됩니다.<br>
                        <select name="item_sc_type" id="item_sc_type">
                            <option value="0">쇼핑몰 기본설정 사용</option>
                            <option value="1">무료배송</option>
                            <option value="2">조건부 무료배송</option>
                            <option value="3">유료배송</option>
                            <option value="4">수량별 부과</option>
                        </select>
                    </td>
                </tr>

                <tr id="sc_con_method">
                    <th scope="row"><label for="item_sc_method">배송비 결제</label></th>
                    <td>
                        <select name="item_sc_method" id="item_sc_method">
                            <option value="0">선불</option>
                            <option value="1">착불</option>
                            <option value="2">사용자선택</option>
                        </select>
                    </td>
                </tr>
                <tr id="sc_con_basic">
                    <th scope="row"><label for="item_sc_price">기본배송비</label></th>
                    <td>무료배송 이외의 설정에 적용되는 배송비 금액입니다.<br>
                        <input type="text" name="item_sc_price" value="0" id="item_sc_price" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 원
                    </td>
                </tr>
                <tr id="sc_con_minimum">
                    <th scope="row"><label for="item_sc_minimum">배송비 상세조건</label></th>
                    <td>
                        주문금액 <input type="text" name="item_sc_minimum" value="0" id="item_sc_minimum" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 이상 무료 배송
                    </td>
                </tr>
                <tr id="sc_con_qty">
                    <th scope="row"><label for="item_sc_qty">배송비 상세조건</label></th>
                    <td>상품의 주문 수량에 따라 배송비가 부과됩니다. 예를 들어 기본배송비가 3,000원 수량을 3으로 설정했을 경우 상품의 주문수량이 5개이면 6,000원 배송비가 부과됩니다.<br>
                        주문수량 <input type="text" name="item_sc_qty" value="0" id="item_sc_qty" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 마다 배송비 부과
                    </td>
                </tr>
            </table>
        </td>
    </tr>


    @for($i = 1; $i <=10; $i++)
    <tr>
        <td>상품 이미지{{ $i }}</td>
        <td>
            <input type="file" name="item_img{{ $i }}" id="item_img{{ $i }}">
            @error('item_img'.$i)
                <strong>{{ $message }}</strong>
            @enderror
        </td>
    </tr>
    @endfor


    <tr colspan="2">
        <td><button type="button" onclick="submitContents();">저장</button></td>
    </tr>

</table>
</form>

<script>
	$(document).ready(function() {
        $(document).on("click", "#caa_id", function() {
			var cate_is = $('#caa_id').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    type: 'post',
                    url: '{{ route('shop.cate.ajax_select') }}',
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
                    url: '{{ route('shop.cate.ajax_select') }}',
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
                    url: '{{ route('shop.cate.ajax_select') }}',
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
                    url: '{{ route('shop.cate.ajax_select') }}',
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
            var cate_is = $('#caa_id5').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('shop.cate.ajax_select') }}',
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

<script>
    $(function() {
        $("#item_point_type").change(function() {
            if(parseInt($(this).val()) > 0)
                $("#item_point_unit").text("%");
            else
                $("#item_point_unit").text("점");
        });
    });
</script>


<script>
    $(function() {  //상품 옵션 관련
        $("#option_table_create").click(function() {
            var it_id = $.trim($("input[name=it_id]").val());
            var opt1_subject = $.trim($("#opt1_subject").val());
            var opt2_subject = $.trim($("#opt2_subject").val());
            var opt3_subject = $.trim($("#opt3_subject").val());
            var opt1 = $.trim($("#opt1").val());
            var opt2 = $.trim($("#opt2").val());
            var opt3 = $.trim($("#opt3").val());
            var $option_table = $("#sit_option_frm");

            if(!opt1_subject || !opt1) {
                alert("옵션명과 옵션항목을 입력해 주십시오.");
                return false;
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                url: '{{ route('shop.item.ajax_itemoption') }}',
                type: 'post',
                dataType: 'html',
                data: {
                    opt1_subject    : opt1_subject,
                    opt2_subject    : opt2_subject,
                    opt3_subject    : opt3_subject,
                    opt1            : opt1,
                    opt2            : opt2,
                    opt3            : opt3,
                },
                success: function(data) {
                    if($.trim(data) == 'No'){
                        alert('옵션1과 옵션1 항목을 입력해 주십시오.');
                        return false;
                    }else{
                        $option_table.empty().html(data);
                    }
                },error: function(data) {
                        console.log(data);
                }
            });

            // 모두선택('현재 DIV 속성 때문에 작동이 잘 안됨 차후 퍼블 작업시 상태 봄')
            $(document).on("click", "input[name=opt_chk_all]", function() {
                if($(this).is(":checked")) {
                    $("input[name='opt_chk[]']").attr("checked", true);
                } else {
                    $("input[name='opt_chk[]']").attr("checked", false);
                }
            });

            // 선택삭제
            $(document).on("click", "#sel_option_delete", function() {
                var $el = $("input[name='opt_chk[]']:checked");
                if($el.length < 1) {
                    alert("삭제하려는 옵션을 하나 이상 선택해 주십시오.");
                    return false;
                }

                $el.closest("tr").remove();
            });

            // 일괄적용
            $(document).on("click", "#opt_value_apply", function() {
                if($(".opt_com_chk:checked").length < 1) {
                    alert("일괄 수정할 항목을 하나이상 체크해 주십시오.");
                    return false;
                }

                var opt_price = $.trim($("#opt_com_price").val());
                var opt_stock = $.trim($("#opt_com_stock").val());
                var opt_noti = $.trim($("#opt_com_noti").val());
                var opt_use = $("#opt_com_use").val();
                var $el = $("input[name='opt_chk[]']:checked");

                // 체크된 옵션이 있으면 체크된 것만 적용
                if($el.length > 0) {
                    var $tr;
                    $el.each(function() {
                        $tr = $(this).closest("tr");

                        if($("#opt_com_price_chk").is(":checked"))
                            $tr.find("input[name='opt_price[]']").val(opt_price);

                        if($("#opt_com_stock_chk").is(":checked"))
                            $tr.find("input[name='opt_stock_qty[]']").val(opt_stock);

                        if($("#opt_com_noti_chk").is(":checked"))
                            $tr.find("input[name='opt_noti_qty[]']").val(opt_noti);

                        if($("#opt_com_use_chk").is(":checked"))
                            $tr.find("select[name='opt_use[]']").val(opt_use);
                    });
                } else {
                    if($("#opt_com_price_chk").is(":checked"))
                        $("input[name='opt_price[]']").val(opt_price);

                    if($("#opt_com_stock_chk").is(":checked"))
                        $("input[name='opt_stock_qty[]']").val(opt_stock);

                    if($("#opt_com_noti_chk").is(":checked"))
                        $("input[name='opt_noti_qty[]']").val(opt_noti);

                    if($("#opt_com_use_chk").is(":checked"))
                        $("select[name='opt_use[]']").val(opt_use);
                }
            });
        });
    });
</script>

<script>
    $(function() {  //추가 옵션 관련
        //추가 옵션 입력필드추가
        $("#add_supply_row").click(function() {
            var $el = $("#sit_supply_frm tr:last");
            var fld = "<tr>\n";
            fld += "<th scope=\"row\">\n";
            fld += "<label for=\"\">추가</label>\n";
            fld += "<input type=\"text\" name=\"spl_subject[]\" value=\"\" size=\"15\">\n";
            fld += "</th>\n";
            fld += "<td>\n";
            fld += "<label for=\"\"><b>추가 항목</b></label>\n";
            fld += "<input type=\"text\" name=\"spl[]\" value=\"\" size=\"40\">\n";
            fld += "<button type=\"button\" id=\"del_supply_row\" >삭제</button>\n";
            fld += "</td>\n";
            fld += "</tr>";

            $el.after(fld);

            supply_sequence();
        });

        function supply_sequence()
        {
            var $tr = $("#sit_supply_frm tr");
            var seq;
            var th_label, td_label;

            $tr.each(function(index) {
                seq = index + 1;
                $(this).find("th label").attr("for", "spl_subject_"+seq).text("추가"+seq);
                $(this).find("th input").attr("id", "spl_subject_"+seq);
                $(this).find("td label").attr("for", "spl_item_"+seq);
                $(this).find("td label b").text("추가"+seq+" 항목");
                $(this).find("td input").attr("id", "spl_item_"+seq);
            });
        }

        // 입력필드삭제
        $(document).on("click", "#del_supply_row", function() {
            $(this).closest("tr").remove();

            supply_sequence();
        });

        // 옵션목록생성
        $("#supply_table_create").click(function() {
            var it_id = $.trim($("input[name=it_id]").val());
            var subject = new Array();
            var supply = new Array();
            var subj, spl;
            var count = 0;
            var $el_subj = $("input[name='spl_subject[]']");
            var $el_spl = $("input[name='spl[]']");
            var $supply_table = $("#sit_option_addfrm");

            $el_subj.each(function(index) {
                subj = $.trim($(this).val());
                spl = $.trim($el_spl.eq(index).val());

                if(subj && spl) {
                    subject.push(subj);
                    supply.push(spl);
                    count++;
                }
            });

            if(!count) {
                alert("추가옵션명과 추가옵션항목을 입력해 주십시오.");
                return false;
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                url: '{{ route('shop.item.ajax_itemsupply') }}',
                type: 'post',
                dataType: 'html',
                data: {
                    'it_id'         : it_id,
                    'subject[]'     : subject,
                    'supply[]'      : supply,
                },

                success: function(data) {
                    if($.trim(data) == 'No'){
                        alert('추가옵션명과 추가옵션항목을 입력해 주십시오.');
                        return false;
                    }else{
                        $supply_table.empty().html(data);
                    }
                },error: function(data) {
                        console.log(data);
                }
            });
        });

        // 모두선택
        $(document).on("click", "input[name=spl_chk_all]", function() {
            if($(this).is(":checked")) {
                $("input[name='spl_chk[]']").attr("checked", true);
            } else {
                $("input[name='spl_chk[]']").attr("checked", false);
            }
        });

        // 선택삭제
        $(document).on("click", "#sel_supply_delete", function() {
            var $el = $("input[name='spl_chk[]']:checked");
            if($el.length < 1) {
                alert("삭제하려는 옵션을 하나 이상 선택해 주십시오.");
                return false;
            }

            $el.closest("tr").remove();
        });

        // 일괄적용
        $(document).on("click", "#spl_value_apply", function() {
            if($(".spl_com_chk:checked").length < 1) {
                alert("일괄 수정할 항목을 하나이상 체크해 주십시오.");
                return false;
            }

            var spl_price = $.trim($("#spl_com_price").val());
            var spl_stock = $.trim($("#spl_com_stock").val());
            var spl_noti = $.trim($("#spl_com_noti").val());
            var spl_use = $("#spl_com_use").val();
            var $el = $("input[name='spl_chk[]']:checked");

            // 체크된 옵션이 있으면 체크된 것만 적용
            if($el.length > 0) {
                var $tr;
                $el.each(function() {
                    $tr = $(this).closest("tr");

                    if($("#spl_com_price_chk").is(":checked"))
                        $tr.find("input[name='spl_price[]']").val(spl_price);

                    if($("#spl_com_stock_chk").is(":checked"))
                        $tr.find("input[name='spl_stock_qty[]']").val(spl_stock);

                    if($("#spl_com_noti_chk").is(":checked"))
                        $tr.find("input[name='spl_noti_qty[]']").val(spl_noti);

                    if($("#spl_com_use_chk").is(":checked"))
                        $tr.find("select[name='spl_use[]']").val(spl_use);
                });
            } else {
                if($("#spl_com_price_chk").is(":checked"))
                    $("input[name='spl_price[]']").val(spl_price);

                if($("#spl_com_stock_chk").is(":checked"))
                    $("input[name='spl_stock_qty[]']").val(spl_stock);

                if($("#spl_com_noti_chk").is(":checked"))
                    $("input[name='spl_noti_qty[]']").val(spl_noti);

                if($("#spl_com_use_chk").is(":checked"))
                    $("select[name='spl_use[]']").val(spl_use);
            }
        });
    });
</script>

<script>
    $("#sc_con_method").hide();
    $("#sc_con_basic").hide();
    $("#sc_con_minimum").hide();
    $("#sc_con_qty").hide();

    $("#item_sc_type").change(function() {
        var type = $(this).val();

        switch(type) {
            case "1":
                $("#sc_con_method").hide();
                $("#sc_con_basic").hide();
                $("#sc_con_minimum").hide();
                $("#sc_con_qty").hide();
                break;
            case "2":
                $("#sc_con_method").show();
                $("#sc_con_basic").show();
                $("#sc_con_minimum").show();
                $("#sc_con_qty").hide();
                break;
            case "3":
                $("#sc_con_method").show();
                $("#sc_con_basic").show();
                $("#sc_con_minimum").hide();
                $("#sc_con_qty").hide();
                break;
            case "4":
                $("#sc_con_method").show();
                $("#sc_con_basic").show();
                $("#sc_con_minimum").hide();
                $("#sc_con_qty").show();
                break;
            default:
                $("#sc_con_method").hide();
                $("#sc_con_basic").hide();
                $("#sc_con_minimum").hide();
                $("#sc_con_qty").hide();
                break;
        }
    });
</script>

<script>
    function submitContents(elClickedObj) {
        oEditors.getById["item_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("item_content").value를 이용해서 처리하면 됩니다.
        var item_content = $("#item_content").val();

        if($("#last_choice_ca_id").val() == ""){
            alert("단계를 선택 하세요.");
            $("#caa_id").focus();
            return false;
        }

        if($.trim($("#item_name").val()) == ""){
            alert("상품명을 입력하세요.");
            $("#item_name").focus();
            return false;
        }

        if($("#item_point_type").val() == "1" || $("#item_point_type").val() == "2"){
            var point = parseInt($("#item_point").val());

            if(point > 99) {
                alert("포인트 비율을 0과 99 사이의 값으로 입력해 주십시오.");
                $("#item_point").focus();
                return false;
            }
        }

        if(parseInt($("#item_sc_type").val()) > 1){
            if(!$("#item_sc_price").val() || $("#item_sc_price").val() == "0"){
                alert("기본배송비를 입력해 주십시오.");
                $("#item_sc_price").focus();
                return false;
            }

            if($("#item_sc_type").val() == "2" && (!$("#item_sc_minimum").val() || $("#item_sc_minimum").val() == "0")){
                alert("배송비 상세조건의 주문금액을 입력해 주십시오.");
                $("#item_sc_minimum").focus();
                return false;
            }

            if($("#item_sc_type").val() == "4" && (!$("#item_sc_qty").val() || $("#item_sc_qty").val() == "0")){
                alert("배송비 상세조건의 주문수량을 입력해 주십시오.");
                $("#item_sc_qty").focus();
                return false;
            }
        }

        if( item_content == ""  || item_content == null || item_content == '&nbsp;' || item_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["item_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}

        $("#item_form").submit();
    }
</script>



@endsection
