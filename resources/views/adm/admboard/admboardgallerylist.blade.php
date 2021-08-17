@extends('layouts.admhead')

@section('content')



<table>
    <tr>
        <td>
            <h4>{{ $board_set_info->bm_tb_subject }}</h4>
        </td>
    </tr>
</table>

<table>
<form name="search_form" id="search_form" method="get" action="{{ route('adm.admboard.index',$tb_name) }}">
<input type="hidden" name="page" id="page" value="{{ $pageNum }}">
<input type="hidden" name="cate" id="cate" value="{{ $cate }}">
    <tr>
        <td>
        @php
            $selected1 = "";
            $selected2 = "";
            $selected3 = "";
            if($keymethod == "bdt_subject" || $keymethod == "") $selected1 = "selected";
            else if($keymethod == "bdt_content") $selected2 = "selected";
            else $selected3 = "selected";
        @endphp
            <select name="keymethod" id="keymethod">
                <option value="bdt_subject" {{ $selected1 }}>제목</option>
                <option value="bdt_content" {{ $selected2 }}>내용</option>
                <option value="all" {{ $selected3 }}>제목+내용</option>
            </select>
        </td>
        <td>
            <input type="text" name="keyword" id="keyword" value="{{ $keyword }}">
        </td>
        <td>
            <button type="button" onclick="search_chk();">검색</button>
        </td>
    </tr>
</form>
</table>


<form name="blist" id="blist" method="post" action="{{ route('adm.admboard.choice_del') }}">
{!! csrf_field() !!}
<input type="hidden" name="tb_name" id="tb_name" value="{{ $tb_name }}">

@if($board_set_info->bm_category_key != "")
<table>
    <tr>
        <td colspan="4">카테고리 {!! $select_disp !!}</td>
    </tr>
</table>
@endif


@if(Auth::user()->user_level <= config('app.ADMIN_LEVEL'))
<table>
    <tr>
        <td>선택 <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk"></td>
    </tr>
</table>
@endif


<table>
    <tr>
        @php
            $tr_num = 0;
            $bdt_file = "";
            $search_link = "";
            $cate_link = "";
            if($keymethod != "" && $keyword != "") $search_link = "&keymethod=".$keymethod."&keyword=".$keyword;
            if($cate != "") $cate_link = "&cate=".$cate;
        @endphp

        @foreach($board_lists as $board_list)
            @php
                if($board_list->bdt_file1 == "") {
                    $bdt_file1_disp = "no_img";
                }else{
                    $bdt_file1_cut = explode("@@",$board_list->bdt_file1);
                    if(count($bdt_file1_cut) == 1) $bdt_file = $bdt_file1_cut[0];
                    else $bdt_file = $bdt_file1_cut[1];

                    $bdt_file1_disp = "/data/board/{$board_list->bm_tb_name}/".$bdt_file;
                }
            @endphp
            <td>
                @if(Auth::user()->user_level <= config('app.ADMIN_LEVEL'))
                <input type="checkbox" name="chk_id[]" value="{{ $board_list->id }}" id="chk_id_{{ $board_list->id }}" class="selec_chk">
                @endif

                <a href="{{ route('adm.admboard.show',$tb_name.'?id='.$board_list->id.'&page='.$pageNum.$cate_link.$search_link) }}">
                <table>
                    <tr>
                        <td>
                            <img src="{{ $bdt_file1_disp }}">
                        </td>
                    </tr>
                    <tr>
                        <td>{!! preg_replace("@({$keyword})@iu", "<font color='red'>$1</font>", mb_substr(stripslashes($board_list->bdt_subject), 0, $board_set_info->bm_subject_len)) !!}</td>
                    </tr>
                </table>
                </a>
            </td>
            @php
                $tr_num++;
                if($tr_num % 4 == 0){
                    echo "</tr><tr>";
                }
            @endphp

        @endforeach
    </tr>
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
        {!! $write_button !!}
        {!! $choice_del_button !!}
    </tr>
</table>

<script>
    function all_checked(sw) {
        var f = document.blist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }
</script>

<script>
    function choice_del(){
        var chk_count = 0;
        var f = document.blist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("삭제할 게시물을 하나 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 게시물을 삭제 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>

<script>
    function category(){
        var cate = $("#bdt_category option:selected").val();
        location.href = "{{ route('adm.admboard.index',$tb_name) }}?cate="+cate;
    }
</script>

<script>
    function search_chk(){
        if($.trim($("#keyword").val()) == ""){
            alert("검색어를 입력 하세요.");
            $("#keyword").focus();
            return false;
        }
        $("#search_form").submit();
    }
</script>




@endsection
