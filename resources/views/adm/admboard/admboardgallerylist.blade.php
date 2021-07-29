@extends('layouts.admhead')

@section('content')

@if($board_set_info->bm_category_key != "")
<table>

    <tr>
        <td colspan="4">카테고리 {!! $select_disp !!}</td>
    </tr>
</table>
@endif


<table>
    <tr>
        @php
            $tr_num = 0;
        @endphp

        @foreach($board_lists as $board_list)
            @php
                if($board_list->bdt_file1 == "") {
                    $bdt_file1_disp = "no_img";
                }else{
                    $bdt_file1_cut = explode("@@",$board_list->bdt_file1);
                    $bdt_file1_disp = "/data/board/{$board_list->bm_tb_name}/".$bdt_file1_cut[1];
                }
            @endphp
            <td>
                <a href="{{ route('adm.admboard.show',$tb_name.'?id='.$board_list->id.'&page='.$pageNum.'&cate='.$cate) }}">
                <table>
                    <tr>
                        <td>
                            <img src="{{ $bdt_file1_disp }}">
                        </td>
                    </tr>
                    <tr>
                        <td>{{ mb_substr(stripslashes($board_list->bdt_subject), 0, $board_set_info->bm_subject_len) }}</td>
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
    function category(){
        var cate = $("#bdt_category option:selected").val();
        location.href = "{{ route('adm.admboard.index',$tb_name) }}?cate="+cate;
    }
</script>






@endsection
