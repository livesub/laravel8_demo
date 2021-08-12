@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>카테고리 관리</h4></td>
    </tr>
    <tr>
        <td>※ 5단계까지 등록 하실수 있습니다.<br>※ 카테고리 삭제는 하위 카테고리가 없거나, 상품이 없어야 삭제 됩니다.<br>※ 상품과 하위 카테고리를 먼저 삭제해 주세요.</td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>번호</td>
        <td>분류 코드</td>
        <td>분류 한글명</td>
        <td>분류 영문명</td>
        <td>단계</td>
        <td>출력여부</td>
        <td>출력순위</td>
        <td>추가/수정/삭제</td>
    </tr>

    @foreach($cate_infos as $cate_info)
        @php
            $blank = "";
            $mark = "";
            $level = strlen($cate_info->ca_id) / 2 - 1;
            for($i = 0; $i < $level; $i++){
                $blank .= "&nbsp&nbsp";
            }

            if($level != 0){
                $mark = "└";
            }

            if($cate_info->ca_display == "Y"){
                $tr_bg = "";
                $disp_ment = "출력";
            }
            else{
                $disp_ment = "<font color='red'>비출력</font>";
                $tr_bg = " bgcolor='red' ";
            }
        @endphp

    <tr {{ $tr_bg }}>
        <td>{{ $virtual_num-- }}</td>
        <td>{{ $cate_info->ca_id }}</td>
        <td>{!! $blank !!}{{ $mark }}{{ $cate_info->ca_name_kr }}</td>
        <td>{{ $cate_info->ca_name_en }}</td>
        <td>{{ $level+1 }}단계</td>
        <td>{!! $disp_ment !!}</td>
        <td>{{ $cate_info->ca_rank }}</td>
        <td>
            @if($level+2 < 6)
            <button type="button" onclick="cate_type('{{ $cate_info->ca_id }}','add');">추가</button>
            @endif

            <button type="button" onclick="cate_type('{{ $cate_info->ca_id }}','modi');">수정</button>
            @php
                $de_cate_info = DB::table('categorys')->where('ca_id','like',$cate_info->ca_id.'%')->count();   //하위 카테고리 갯수
                $de_item_info = DB::table('items')->where('ca_id','like',$cate_info->ca_id.'%')->count();   //상품 갯수
            @endphp

            @if($de_cate_info == 1 && $de_item_info == 0)
                <button type="button" onclick="cate_del('{{ $cate_info->id }}','{{ $cate_info->ca_id }}');">삭제</button></td>
            @endif
    </tr>
    @endforeach
</table>


<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.cate.catecreate') }}'">카테고리 등록</button></td>
    </tr>
</table>



<table>
    <tr>
        <td>
           {!! $pageList !!}
        </td>
    </tr>
</table>


<form name="cate_form" id="cate_form" method="post" action="">
{!! csrf_field() !!}
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="ca_id" id="ca_id">
    <input type="hidden" name="page" id="page" value="{{ $pageNum }}">
</form>

<script>
    function cate_type(ca_id, type){
        $("#ca_id").val(ca_id);
        if(type == "add"){
            $("#cate_form").attr("action", "{{ route('adm.cate.cate_add') }}");
        }else if(type == "modi"){
            $("#cate_form").attr("action", "{{ route('adm.cate.cate_modi') }}");
        }

        $("#cate_form").submit();
    }
</script>

<script>
    function cate_del(id,ca_id){
        $("#id").val(id);
        $("#ca_id").val(ca_id);

        if (confirm("상품이 있을 경우 상품 부터 삭제 하세요.\n정말 삭제하시겠습니까?") == true){
            $("#cate_form").attr("action", "{{ route('adm.cate.cate_delete') }}");
            $("#cate_form").submit();
        }else{
            return false;
        }
    }
</script>




@endsection
