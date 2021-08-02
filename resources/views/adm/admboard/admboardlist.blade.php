@extends('layouts.admhead')

@section('content')



<table>
    <tr>
        <td>
            <h4>{{ $board_set_info->bm_tb_subject }}</h4>
        </td>
    </tr>
</table>
<table border=1>
    <form name="blist" id="blist" method="post" action="{{ route('adm.admboard.choice_del') }}">
    {!! csrf_field() !!}
    <input type="hidden" name="tb_name" id="tb_name" value="{{ $tb_name }}">

    @if($board_set_info->bm_category_key != "")
    <tr>
        <td>카테고리</td>
        <td colspan="5">{!! $select_disp !!}</td>
    </tr>
    @endif


    <tr>
        @if(Auth::user() != "")
            @if(Auth::user()->user_level <= config('app.ADMIN_LEVEL'))
        <td>선택<br><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk"></td>
            @endif
        @endif

        <td>번호</td>
        <td>제목</td>
        <td>글쓴이</td>
        <td>조회수</td>
        <td>덧글수</td>
    </tr>


    @foreach($board_lists as $board_list)
    <tr>
        @if(Auth::user() != "")
            @if(Auth::user()->user_level <= config('app.ADMIN_LEVEL'))
        <td><input type="checkbox" name="chk_id[]" value="{{ $board_list->id }}" id="chk_id_{{ $board_list->id }}" class="selec_chk"></td>
            @endif
        @endif
        <td>{{ $virtual_num-- }}</td>

        <td>
            @if($board_list->bdt_del != 'Y')
            <a href="{{ route('adm.admboard.show',$tb_name.'?id='.$board_list->id.'&page='.$pageNum.'&cate='.$cate) }}">
            @endif

                @if ($board_list->bdt_depth == 0)
                    {{ mb_substr(stripslashes($board_list->bdt_subject), 0, $board_set_info->bm_subject_len) }}
                @else
                @for ($i=0; $i<$board_list->bdt_depth; $i++)
                    &nbsp&nbsp
                @endfor
                └{{ mb_substr(stripslashes($board_list->bdt_subject), 0, $board_set_info->bm_subject_len) }}
                @endif

            @if($board_list->bdt_del != 'Y')
            </a>
            @endif

        </td>

        <td>{{ $board_list->bdt_uname }}</td>
        <td>{{ $board_list->bdt_hit }}</td>
        <td>{{ $board_list->bdt_comment_cnt }}</td>
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



@endsection
