<table border=1>
    <tr>
        <td>배송지 목록</td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>배송지명</td>
                    <td>이름</td>
                    <td>배송지정보</td>
                    <td>관리</td>
                </tr>
                @php
                    $sep = chr(30);
                    $i = 0;
                    $addr = '';
                @endphp

                @foreach($baesongjis as $baesongji)
                    @php
                    $addr = $baesongji->ad_name.$sep.$baesongji->ad_tel.$sep.$baesongji->ad_hp.$sep.$baesongji->ad_zip1.$sep.$baesongji->ad_addr1.$sep.$baesongji->ad_addr2.$sep.$baesongji->ad_addr3.$sep.$baesongji->ad_jibeon.$sep.$baesongji->ad_subject;
                    @endphp
                <tr>
                    <td>
                        <input type="hidden" name="id[{{ $i }}]" value="{{ $baesongji->id }}">
                        <input type="checkbox" name="chk[]" value="{{ $i }}" id="chk_{{ $i }}">
                        <input type="text" name="ad_subject[{{ $i }}]" id="ad_subject{{ $i }}" size="12" maxlength="20" value="{{ $baesongji->ad_subject }}">
                    </td>
                    <td>{{ $baesongji->ad_name }}</td>
                    <td>
                        {{ $baesongji->ad_addr1 }} {{ $baesongji->ad_addr2 }} {{ $baesongji->ad_addr3 }} {{ $baesongji->ad_jibeon }}<br>
                        <span class="ad_tel">{{ $baesongji->ad_tel }} / {{ $baesongji->ad_hp }}</span>
                    </td>
                    <td>
                        <input type="hidden" id="addr{{ $i }}" value="{{ $addr }}">
                        <button type="button" onclick="return_addr('{{ $i }}');">선택</button>
                        <a href="" class="del_address mng_btn">삭제</a>
                        <input type="radio" name="ad_default" value="" id="ad_default" >
                        <label for="ad_default" class="default_lb mng_btn">기본배송지</label>
                    </td>
                </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach

            </table>
        </td>
    <tr>
</table>

<script>
    function return_addr(num){
        var addr = $("#addr"+num).val().split(String.fromCharCode(30));
        alert(addr);
    }

/*
$(function() {
    $(".sel_address").on("click", function() {
        var addr = $(this).siblings("input").val().split(String.fromCharCode(30));

        var f = window.opener.forderform;
        f.od_b_name.value        = addr[0];
        f.od_b_tel.value         = addr[1];
        f.od_b_hp.value          = addr[2];
        f.od_b_zip.value         = addr[3] + addr[4];
        f.od_b_addr1.value       = addr[5];
        f.od_b_addr2.value       = addr[6];
        f.od_b_addr3.value       = addr[7];
        f.od_b_addr_jibeon.value = addr[8];
        f.ad_subject.value       = addr[9];

        var zip1 = addr[3].replace(/[^0-9]/g, "");
        var zip2 = addr[4].replace(/[^0-9]/g, "");

        if(zip1 != "" && zip2 != "") {
            var code = String(zip1) + String(zip2);

            if(window.opener.zipcode != code) {
                window.opener.zipcode = code;
                window.opener.calculate_sendcost(code);
            }
        }

        window.close();
    });

    $(".del_address").on("click", function() {
        return confirm("배송지 목록을 삭제하시겠습니까?");
    });

    // 전체선택 부분
    $("#chk_all").on("click", function() {
        if($(this).is(":checked")) {
            $("input[name^='chk[']").attr("checked", true);
        } else {
            $("input[name^='chk[']").attr("checked", false);
        }
    });

    $(".btn_submit").on("click", function() {
        if($("input[name^='chk[']:checked").length==0 ){
            alert("수정하실 항목을 하나 이상 선택하세요.");
            return false;
        }
    });

});
*/
</script>