@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>메뉴 리스트</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>번호</td>
        <td>분류코드</td>
        <td>영문명</td>
        <td>한글명</td>
        <td>단계</td>
        <td>페이지 타입</td>
        <td>출력순서</td>
        <td>출력여부</td>
        <td>추가/수정/삭제</td>
    </tr>

    @foreach($menu_infos as $menu_info)
        @php
            $blank = "";
            $mark = "";
            $level = strlen($menu_info->menu_id) / 2 - 1;
            for($i = 0; $i < $level; $i++){
                $blank .= "&nbsp&nbsp";
            }

            if($level != 0){
                $mark = "└";
            }

            if($menu_info->menu_display == "Y"){
                $tr_bg = "";
                $disp_ment = "출력";
            }
            else{
                $disp_ment = "<font color='red'>비출력</font>";
                $tr_bg = " bgcolor='red' ";
            }

            if($menu_info->menu_page_type == "P") $menu_page_type = "일반 HTML";
            else $menu_page_type = "게시판";
        @endphp
    <tr {{ $tr_bg }}>
        <td>{{ $virtual_num-- }}</td>
        <td>{{ $menu_info->menu_id }}</td>
        <td>{!! $blank !!}{{ $mark }}{{ $menu_info->menu_name_en }}</td>
        <td>{{ $menu_info->menu_name_kr }}</td>
        <td>{{ $level+1 }}단계</td>
        <td>{{ $menu_page_type }}</td>
        <td>{{ $menu_info->menu_rank }}</td>
        <td>{!! $disp_ment !!}</td>
        <td>
            @if($level+2 < 4)
            <button type="button" onclick="menu_type('{{ $menu_info->menu_id }}','add');">추가</button>
            @endif
            <button type="button" onclick="menu_type('{{ $menu_info->menu_id }}','modi');">수정</button>

            @php
                $down_memu_info = DB::table('menuses')->where('menu_id','like',$menu_info->menu_id.'%')->count();   //하위 카테고리 갯수
            @endphp

            @if($down_memu_info == 1)
            <button type="button" onclick="menu_del('{{ $menu_info->id }}','{{ $menu_info->menu_id }}');">삭제</button>
            @endif
        </td>
    </tr>
    @endforeach

</table>

<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.menu.create') }}'">1단계 메뉴 등록</button></td>
    </tr>
</table>


<table>
    <tr>
        <td>
           {!! $pageList !!}
        </td>
    </tr>
</table>



<form name="menu_form" id="menu_form" method="get" action="">
    <input type="hidden" name="menu_id" id="menu_id">
    <input type="hidden" name="page" id="page" value="{{ $pageNum }}">
</form>

<form name="menu_del_form" id="menu_del_form" method="post" action="{{ route('adm.menu.delete') }}">
{!! csrf_field() !!}
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="menu_id" id="del_menu_id">
    <input type="hidden" name="page" id="del_page" value="{{ $pageNum }}">
</form>

<script>
    function menu_type(menu_id, type){
        $("#menu_id").val(menu_id);
        if(type == "add"){
            $("#menu_form").attr("action", "{{ route('adm.menu.menu_add') }}");
        }else if(type == "modi"){
            $("#menu_form").attr("action", "{{ route('adm.menu.menu_modi') }}");
        }

        $("#menu_form").submit();
    }
</script>

<script>
    function menu_del(id,menu_id){
        $("#id").val(id);
        $("#del_menu_id").val(menu_id);

        if (confirm("메뉴를 삭제하시겠습니까?") == true){
            $("#menu_del_form").submit();
        }else{
            return false;
        }
    }
</script>


@endsection
