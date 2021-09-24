@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>쇼핑몰 상품 리스트</h4></td>
    </tr>
</table>

<table>
<form name="search_form" id="search_form" method="get" action="{{ route('shop.item.index') }}">
    <tr>
        <td>
            <select name="ca_id" id="ca_id">
                <option value="">전체분류</option>
                @foreach($search_selectboxs as $search_selectbox)
                    @php
                        $len = strlen($search_selectbox->sca_id) / 2 - 1;
                        $nbsp = '';
                        for ($i=0; $i<$len; $i++) $nbsp .= '&nbsp;&nbsp;&nbsp;';
                        if($search_selectbox->sca_id == $ca_id) $cate_selected = "selected";
                        else $cate_selected = "";
                    @endphp

                    <option value="{{ $search_selectbox->sca_id }}" {{ $cate_selected }}>{!! $nbsp !!}{{ $search_selectbox->sca_name_kr }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="item_search" id="item_search">
                @php
                    if($item_search == "item_name" || $item_search == "") $item_name_selected = "selected";
                    else $item_name_selected = "";

                    if($item_search == "item_code") $item_code_selected = "selected";
                    else $item_code_selected = "";
                @endphp
                <option value="item_name" {{ $item_name_selected }}>상품명</option>
                <option value="item_code" {{ $item_code_selected }}>상품코드</option>
            </select>
        </td>
        <td>
            <input type="text" name="keyword" id="keyword" value="{{ $keyword }}"><button type="">검색</button>
        </td>
    </tr>
</form>
</table>

<table border=1>
<form name="itemlist" id="itemlist" method="post" action="{{ route('shop.item.choice_del') }}">
{!! csrf_field() !!}
    <tr>
        <td>선택<br><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk"></td>
        <td>번호</td>
        <td>이미지</td>
        <td>분류</td>
        <td>상품코드</td>
        <td>상품명</td>
        <td>출력순서</td>
        <td>관리</td>
    </tr>


    @foreach($item_infos as $item_info)
        @php
            //단계명 가져 오기
            $cut_hap = "";
            $item_ca_name = "";
            $ca_name_hap = "";
            $ca_id_len = 0;

            for($i = 0; $i < 10; $i += 2)
            {
                $sign = "";
                $ca_id_len = strlen($item_info->sca_id) - 2;
                $tmp_cut = substr($item_info->sca_id, $i, 2);
                if($tmp_cut != ""){
                    $cut_hap = $cut_hap.$tmp_cut;
                    $item_ca_name = DB::table('shopcategorys')->select('sca_name_kr', 'sca_name_en')->where('sca_id',$cut_hap)->first();

                    if($ca_id_len > $i){
                        $sign = " > ";
                    }

                    if($item_ca_name->sca_name_kr != ""){
                        $ca_name_hap .= $item_ca_name->sca_name_kr.$sign;
                    }
                }
            }

            //이미지 처리
            if($item_info->item_img1 == "") {
                $item_img_disp = asset("img/no_img.jpg");
            }else{
                $item_img_cut = explode("@@",$item_info->item_img1);
                $item_img_disp = "/data/shopitem/".$item_img_cut[3];
            }
        @endphp
    <tr>
        <td><input type="checkbox" name="chk_id[]" value="{{ $item_info->id }}" id="chk_id_{{ $item_info->id }}" class="selec_chk"></td>
        <td>{{ $virtual_num-- }}</td>
        <td><img src="{{ $item_img_disp }}" style="width:100px;height:100px;"></td>
        <td>{{ $ca_name_hap }}</td>
        <td>{{ $item_info->item_code }}</td>
        <td>{{ stripslashes($item_info->item_name) }}</td>
        <td>{{ $item_info->item_rank }}</td>
        <td>
            <button type="button" onclick="item_modi('{{ $item_info->id }}','{{ $item_info->sca_id }}');">수정</button>
        </td>
    </tr>
    @endforeach


</form>
</table>



<table>
    <tr>
        <td>
           {!! $pageList !!}
        </td>
    </tr>
</table>


<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('shop.item.create') }}'">상품등록</button></td>
        <td><button type="button" onclick="choice_del();">선택 삭제</button></td>
    </tr>
</table>


<script>
    function all_checked(sw) {
        var f = document.itemlist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }
</script>

<script>
    function choice_del(){
        var chk_count = 0;
        var f = document.itemlist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("삭제할 상품을 하나 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 상품을 삭제 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>

<!-- validate 하기 위해선 get 방식으로 던져야 함 -->
<form name="item_modi_form" id="item_modi_form" method="get" action="{{ route('shop.item.modify') }}">
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="sca_id" id="sca_id">
</form>

<script>
    function item_modi(id, sca_id){
        $("#id").val(id);
        $("#sca_id").val(sca_id);

        $("#item_modi_form").submit();
    }
</script>

<script>
    $("#ca_id").change(function(){
        location.href = "{{ route('shop.item.index') }}?ca_id="+$(this).val();
    });
</script>




@endsection
