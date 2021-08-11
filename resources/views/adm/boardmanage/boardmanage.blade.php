@extends('layouts.admhead')

@section('content')


<table border=1>
    <tr>
        <td><h4>{{ $bmm_title }}</h4></td>
    </tr>
    <tr>
        <td>{{ $bmm_subtitle }}</td>
    </tr>
    <tr>
        <td>
            <table border="1">
                <tr>
                    <td>{{ $bmm_tb_name }}</td>
                    <td>{{ $bmm_tb_subject }}</td>
                    <td>권한</td>
                    <td>기능</td>
                </tr>


                @foreach($b_lists as $b_list)
                <tr>
                    <td>{{ $b_list->bm_tb_name }}</td>
                    <td>{{ $b_list->bm_tb_subject }}</td>
                    <td>권한</td>
                    <td><button type="button" onclick="board_setting({{ $b_list->id }});">설정</button>
                    <button type="button" onclick="board_setting_del({{ $b_list->id }},'{{ $b_list->bm_tb_name }}');">삭제</button></td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>

    <tr>
        <td>게시판 추가</td>
    </tr>
    <tr>
        <td>
            <table border="1">
                <form name="b_add" id="b_add" method="post" action="{{ route('adm.boardmanage.create') }}">
                {!! csrf_field() !!}
                <tr>
                    <td>게시판명</td>
                    <td>
                        <input type="text" name="bm_tb_name" id="bm_tb_name">
                        @error('bm_tb_name')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </td>
                </tr>

                <tr>
                    <td>게시판제목</td>
                    <td><input type="text" name="bm_tb_subject" id="bm_tb_subject"></td>
                </tr>

                <tr>
                    <td>파일 사용 갯수</td>
                    <td>
                        <select name="bm_file_num" id="bm_file_num">
                            @for($i = 0; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>게시판 종류</td>
                    <td>
                        <select name="bm_type" id="bm_type">
                            <option value="1">일반게시판</option>
                            <option value="2">갤러리게시판</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>게시판 스킨</td>
                    <td>{!! $directory_disp !!}</td>
                </tr>

                <tr>
                    <td colspan=2>
                        <button type="button" onclick="board_add();">게시판 추가</button>
                    </td>
                <tr>
                </form>
            </table>
        </td>
    </tr>
</table>

<form name="b_set" id="b_set" action="{{ route('adm.boardmanage.show') }}" method="POST">
{!! csrf_field() !!}
    <input type="hidden" name="num" id="num" value="">
    <input type="hidden" name="b_id" id="b_id" value="">
    <input type="hidden" name="bm_tb_name" id="del_bm_tb_name" value="">
</form>

<script>
    $(document).ready(function(){
    //한글입력 안되게 처리
        $("#bm_tb_name").keyup(function(event){
            if (!(event.keyCode >=37 && event.keyCode<=40)) {
                var inputVal = $(this).val();
                $(this).val(inputVal.replace(/[^a-z0-9_]/gi,''));
            }
        });
    });

    function board_add(){
        if($.trim($("#bm_tb_name").val()) == ""){
            alert("게시판명을 영문으로 공백 없이 입력하세요.");
            $("#bm_tb_name").focus();
            return false;
        }

        if($.trim($("#bm_tb_subject").val()) == ""){
            alert("게시판 제목을 입력하세요.");
            $("#bm_tb_subject").focus();
            return false;
        }

        $("#b_add").submit();
    }
</script>

<script>
    function board_setting(num){
        $("#num").val(num);
        $("#b_set").submit();
    }
</script>

<script>
    function board_setting_del(b_id, bm_tb_name){
        if (confirm("게시판의 게시물과 댓글, 첨부파일까지 모두 삭제 됩니다.\n\n게시판을 삭제 하시겠습니까?") == true){    //확인
            $("#b_id").val(b_id);
            $("#del_bm_tb_name").val(bm_tb_name);
            $("#b_set").attr("action", "{{ route('adm.boardmanage.destroy') }}");
            $("#b_set").submit();
        }else{
            return;
        }
    }
</script>

@endsection
