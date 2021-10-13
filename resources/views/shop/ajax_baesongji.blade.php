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

                    $checked = "";
                    if($baesongji->ad_default == 1) $checked = "checked";
                    @endphp
                <tr>
                    <td>
                        <input type="hidden" name="id[{{ $i }}]" id="id[{{ $i }}]" value="{{ $baesongji->id }}">
                        <input type="checkbox" name="chk[]" id="chk_{{ $i }}" value="{{ $i }}">
                        <input type="text" name="ad_subject_ori[{{ $i }}]" id="ad_subject_ori{{ $i }}" size="12" maxlength="20" value="{{ $baesongji->ad_subject }}">
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
                        <input type="radio" name="ad_default_ori" value="{{ $baesongji->id }}" id="ad_default{{ $i }}" {{ $checked }}>
                        <label for="ad_default_ori" class="default_lb mng_btn">기본배송지</label>
                    </td>
                </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach

                <tr>
                    <td><button type="button" onclick="choice_modi();">선택수정</button><button type="button" onclick="lay_close();">닫기</button></td>
                </tr>
            </table>
        </td>
    <tr>
</table>

<script>
    function return_addr(num){
        var addr = $("#addr"+num).val().split(String.fromCharCode(30));
        //alert(addr);

        $("#od_b_name").val(addr[0]);
        $("#od_b_tel").val(addr[1]);
        $("#od_b_hp").val(addr[2]);
        $("#od_b_zip").val(addr[3]);
        $("#od_b_addr1").val(addr[4]);
        $("#od_b_addr2").val(addr[5]);
        $("#od_b_addr3").val(addr[6]);
        $("#od_b_addr_jibeon").val(addr[7]);
        $("#ad_subject").val(addr[8]);
    }

    function choice_modi(){
        if($("input[name^='chk[']:checked").length==0 ){
            alert("수정하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        var queryString = $("#forderform").serialize();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_baesongji_modi') }}',
            data : queryString,
            dataType : 'text',
            success : function(result){
//alert(result);
//return false;
                if(result == "no_mem"){
                    alert("회원이시라면 회원로그인 후 이용해 주십시오.");
                    return false;
                }

                if(result == "ok"){
                    baesongji();
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }

    function lay_close(){
        $("#disp_baesongi").html("");
    }
</script>