@extends('layouts.admhead')

@section('content')


<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
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
<input type="hidden" name="last_choice_ca_id" id="last_choice_ca_id" value="{{ $item_info->sca_id }}">
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
                                        if($one_str_cut == $one_step_info->sca_id) $one_selected = "selected";
                                        else $one_selected = "";
                                    @endphp

                                    <option value="{{ $one_step_info->sca_id }}" {{ $one_selected }}>{{ $one_step_info->sca_name_kr }}</option>
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
                                        if($two_str_cut == $two_step_info->sca_id) $two_selected = "selected";
                                        else $two_selected = "";
                                    @endphp

                                    <option value="{{ $two_step_info->sca_id }}" {{ $two_selected  }}>{{ $two_step_info->sca_name_kr }}</option>
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
                                        if($three_str_cut == $three_step_info->sca_id) $three_selected = "selected";
                                        else $three_selected = "";
                                    @endphp

                                    <option value="{{ $three_step_info->sca_id }}" {{ $three_selected }}>{{ $three_step_info->sca_name_kr }}</option>
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
                                        if($four_str_cut == $four_step_info->sca_id) $four_selected = "selected";
                                        else $four_selected = "";
                                    @endphp

                                    <option value="{{ $four_step_info->sca_id }}" {{ $four_selected }}>{{ $four_step_info->sca_name_kr }}</option>
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
                                        if($five_str_cut == $five_step_info->sca_id) $five_selected = "selected";
                                        else $five_selected = "";
                                    @endphp

                                    <option value="{{ $five_step_info->sca_id }}" {{ $five_selected }}>{{ $five_step_info->sca_name_kr }}</option>
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
        <td>기본설명</td>
        <td><input type="text" name="item_basic" id="item_basic" value="{{ $item_info->item_basic }}"></td>
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
        <td>상품 유형</td>
        <td>
            <span class="frm_info">메인화면에 유형별로 출력할때 사용합니다.<br>이곳에 체크하게되면 상품리스트에서 유형별로 정렬할때 체크된 상품이 가장 먼저 출력됩니다.</span><br>
            @php
                if($item_info->item_type1 == 1) $item_type1_checked = "checked";
                else $item_type1_checked = "";

                if($item_info->item_type2 == 1) $item_type2_checked = "checked";
                else $item_type2_checked = "";

                if($item_info->item_type3 == 1) $item_type3_checked = "checked";
                else $item_type3_checked = "";

                if($item_info->item_type4 == 1) $item_type4_checked = "checked";
                else $item_type4_checked = "";
            @endphp
            <input type="checkbox" name="item_type1" value="1"  id="item_type1" {{ $item_type1_checked }}>
            <label for="item_type1">히트 </label>
            <input type="checkbox" name="item_type2" value="1"  id="item_type2" {{ $item_type2_checked }}>
            <label for="item_type2">신상품 </label>
            <input type="checkbox" name="item_type3" value="1"  id="item_type3" {{ $item_type3_checked }}>
            <label for="item_type3">인기 </label>
            <input type="checkbox" name="item_type4" value="1"  id="item_type4" {{ $item_type4_checked }}>
            <label for="item_type4">할인 </label>
        </td>
    </tr>

    <tr>
        <td>제조사</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_manufacture" id="item_manufacture" value="{{ $item_info->item_manufacture }}">
        </td>
    </tr>

    <tr>
        <td>원산지</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_origin" id="item_origin" value="{{ $item_info->item_origin }}">
        </td>
    </tr>

    <tr>
        <td>브랜드</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_brand" id="item_brand" value="{{ $item_info->item_brand }}">
        </td>
    </tr>

    <tr>
        <td>모델</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_model" id="item_model" value="{{ $item_info->item_model }}">
        </td>
    </tr>

    <tr>
        <td>전화문의</td>
        <td>상품 금액 대신 전화문의로 표시됩니다. <br>
            @php
                if($item_info->item_tel_inq == 1) $item_tel_inq_checked = 'checked';
                else $item_tel_inq_checked = '';
            @endphp
            <input type="checkbox" name="item_tel_inq" value="1" id="item_tel_inq" {{ $item_tel_inq_checked }}> 예
        </td>
    </tr>

    <tr>
        <td>판매가능</td>
        <td>잠시 판매를 중단하거나 재고가 없을 경우에 체크를 해제해 놓으면 출력되지 않으며, 주문도 받지 않습니다. <br>
            @php
                if($item_info->item_use == 1) $item_use_checked = 'checked';
                else $item_use_checked = '';
            @endphp
            <input type="checkbox" name="item_use" value="1" id="item_use" {{ $item_use_checked }}> 예
        </td>
    </tr>

    <tr>
        <td>쿠폰적용안함</td>
        <td>설정에 체크하시면 쿠폰 생성 때 상품 검색 결과에 노출되지 않습니다.. <br>
            @php
                if($item_info->item_nocoupon == 1) $item_nocoupon_checked = 'checked';
                else $item_nocoupon_checked = '';
            @endphp
            <input type="checkbox" name="item_nocoupon" value="1" id="item_nocoupon" {{ $item_nocoupon_checked }}> 예
        </td>
    </tr>

    <tr>
        <td>상품내용</td>
        <td>
            <textarea type="text" name="item_content" id="item_content" style="width:100%">{{ $item_info->item_content }}</textarea>
        </td>
    </tr>




    <tr>
        <td>판매가격</td>
        <td><input type="text" name="item_price" id="item_price" value="{{ $item_info->item_price }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">원</td>
    </tr>

    <tr>
        <td>시중가격</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다.<br>
            <input type="text" name="item_cust_price" id="item_cust_price" value="{{ $item_info->item_cust_price }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">원
        </td>
    </tr>

    <tr>
        <td>포인트 유형</td>
        <td>포인트 유형을 설정할 수 있습니다. <br>비율로 설정했을 경우 설정 기준금액의 %비율로 포인트가 지급됩니다.<br>
            @php
                $item_point_type0 = "";
                $item_point_type1 = "";
                $item_point_type2 = "";
                if($item_info->item_point_type == "0") $item_point_type0 = "selected";
                if($item_info->item_point_type == "1") $item_point_type1 = "selected";
                if($item_info->item_point_type == "2") $item_point_type2 = "selected";
            @endphp
            <select name="item_point_type" id="item_point_type">
                    <option value="0" {{ $item_point_type0 }}>설정금액</option>
                    <option value="1" {{ $item_point_type1 }}>판매가기준 설정비율</option>
                    <option value="2" {{ $item_point_type2 }}>구매가기준 설정비율</option>
                </select>
        </td>
    </tr>

    <tr>
        <td>포인트</td>
        <td>주문완료후 환경설정에서 설정한 주문완료 설정일 후 회원에게 부여하는 포인트입니다.<br>또, 포인트부여를 '아니오'로 설정한 경우 신용카드, 계좌이체로 주문하는 회원께는 부여하지 않습니다.<br>
            <input type="text" name="item_point" value="{{ $item_info->item_point }}" id="item_point" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
            @php
                if($item_info->item_point_type) $item_point_type_exp = '%';
                else $item_point_type_exp = '점';
            @endphp
            <span id="item_point_unit">{{ $item_point_type_exp }}</span>
        </td>
    </tr>

    <tr>
        <td>추가옵션상품 포인트</td>
        <td>상품의 추가옵션상품 구매에 일괄적으로 지급하는 포인트입니다. <br>0으로 설정하시면 구매포인트를 지급하지 않습니다.<br>
        주문완료후 환경설정에서 설정한 주문완료 설정일 후 회원에게 부여하는 포인트입니다.<br>
        또, 포인트부여를 '아니오'로 설정한 경우 신용카드, 계좌이체로 주문하는 회원께는 부여하지 않습니다.<br>
            <input type="text" name="item_supply_point" value="{{ $item_info->item_supply_point }}" id="item_supply_point" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 점
        </td>
    </tr>

    <tr>
        <td>상품품절</td>
        <td>잠시 판매를 중단하거나 재고가 없을 경우에 체크해 놓으면 품절상품으로 표시됩니다.<br>
            @php
                if($item_info->item_soldout == 1) $item_soldout_checked = "checked";
                else $item_soldout_checked = "";
            @endphp
            <input type="checkbox" name="item_soldout" value="1" id="item_soldout" {{ $item_soldout_checked }}> 예
        </td>
    </tr>

    <tr>
        <td>재고수량</td>
        <td>주문관리에서 상품별 상태 변경에 따라 자동으로 재고를 가감합니다. <br>재고는 규격/색상별이 아닌, 상품별로만 관리됩니다.<br>재고수량을 0으로 설정하시면 품절상품으로 표시됩니다.<br>
            <input type="text" name="item_stock_qty" value="{{ $item_info->item_stock_qty }}" id="item_stock_qty" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 개
        </td>
    </tr>

    <tr>
        <td>상품선택옵션</td>
        <td>옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다.<br> 옷을 예로 들어 [옵션1 : 사이즈 , 옵션1 항목 : XXL,XL,L,M,S] , [옵션2 : 색상 , 옵션2 항목 : 빨,파,노]<br><strong>옵션명과 옵션항목에 따옴표(', ")는 입력할 수 없습니다.</strong><br>
            <table border=1>
                <tr>
                    <td>
                        <table>
                        @php
                            $opt_subject = "";
                            $opt_subject = explode(',', $item_info->item_option_subject);

                            if(isset($opt_subject[0])) $opt_subject[0] = $opt_subject[0];
                            else $opt_subject[0] = "";

                            if(isset($opt_subject[1])) $opt_subject[1] = $opt_subject[1];
                            else $opt_subject[1] = "";

                            if(isset($opt_subject[2])) $opt_subject[2] = $opt_subject[2];
                            else $opt_subject[2] = "";
                        @endphp

                            <tr>
                                <td>옵션1
                                    <input type="text" name="opt1_subject" value="{{ $opt_subject[0] }}" id="opt1_subject" size="15">
                                </td>
                                <td>옵션1 항목
                                    <input type="text" name="opt1" value="" id="opt1" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td>옵션2
                                    <input type="text" name="opt2_subject" value="{{ $opt_subject[1] }}" id="opt2_subject" size="15">
                                </td>
                                <td>옵션2 항목
                                    <input type="text" name="opt2" value="" id="opt2" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td>옵션3
                                    <input type="text" name="opt3_subject" value="{{ $opt_subject[2] }}" id="opt3_subject" size="15">
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
<script>
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
        url: '{{ route('shop.item.ajax_modi_itemoption') }}',
        type: 'post',
        dataType: 'html',
        data: {
            item_code       : '{{ $item_info->item_code }}',
            opt1_subject    : $.trim($("#opt1_subject").val()),
            opt2_subject    : $.trim($("#opt2_subject").val()),
            opt3_subject    : $.trim($("#opt3_subject").val()),
        },
        success: function(data) {
            $("#sit_option_frm").empty().html(data);
        },error: function(data) {
            console.log(data);
        }
    });

    $(function() {
        //옵션항목설정
        var arr_opt1 = new Array();
        var arr_opt2 = new Array();
        var arr_opt3 = new Array();
        var opt1 = opt2 = opt3 = '';
        var opt_val;

        $(".opt-cell").each(function() {
            opt_val = $(this).text().split(" > ");
            opt1 = opt_val[0];
            opt2 = opt_val[1];
            opt3 = opt_val[2];

            if(opt1 && $.inArray(opt1, arr_opt1) == -1)
                arr_opt1.push(opt1);

            if(opt2 && $.inArray(opt2, arr_opt2) == -1)
                arr_opt2.push(opt2);

            if(opt3 && $.inArray(opt3, arr_opt3) == -1)
                arr_opt3.push(opt3);
        });

        $("input[name=opt1]").val(arr_opt1.join());
        $("input[name=opt2]").val(arr_opt2.join());
        $("input[name=opt3]").val(arr_opt3.join());

        // 옵션목록생성
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
        });

        // 모두선택
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
</script>
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





    <tr>
        <td>상품 이미지</td>
        <td>
            <input type="file" name="item_img" id="item_img">
            @error('item_img')
                <strong>{{ $message }}</strong>
            @enderror

                <br><a href="javascript:file_down('{{ $item_info->id }}','{{ $item_info->sca_id }}');">{{ $item_info->item_ori_img1 }}</a><br>
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
            var num = 0;
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
    function file_down(id, ca_id)
    {
        $("#num").val(id);
        $("#ca_id").val(ca_id);
        $("#item_form").attr("action", "{{ route('adm.item.downloadfile') }}");
        $("#item_form").submit();
    }
</script>

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





@endsection
