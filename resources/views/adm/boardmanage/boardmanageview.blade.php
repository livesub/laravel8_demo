@extends('layouts.admhead')

@section('content')


<table border=1>
<form name="b_save" id="b_save" method="POST" action="{{ route('adm.boardmanage.store') }}">
{!! csrf_field() !!}
<input type="hidden" name="num" id="num" value="{{ $board_info->id }}">

    <tr>
        <td>
            테이블명
        </td>
        <td>
            {{ $board_info->bm_tb_name }}
        </td>
    </tr>
    <tr>
        <td>
            게시판 제목
        </td>
        <td>
            <input type="text" name="bm_tb_subject" id="bm_tb_subject" value="{{ $board_info->bm_tb_subject }}">
        </td>
    </tr>
    <tr>
        <td>
            파일 사용 갯수
        </td>
        <td>
            <select name="bm_file_num" id="bm_file_num">
                @for($i = 0; $i <= 5; $i++)

                    @php
                    if($i == $board_info->bm_file_num) $selected = 'selected';
                    else $selected = '';
                    @endphp

                    <option value="{{ $i }}" {{ $selected }}>{{ $i }}</option>
                @endfor
            </select>
        </td>
    </tr>
    <tr>
        <td>
            리사이징(이미지일때만)
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" name="bm_resize_max_size" id="bm_resize_max_size" value="{{ $board_info->bm_resize_max_size }}" size="3"> 원본이미지 최대허용길이&nbsp&nbsp<input type="text" name="bm_resize_file_num" id="bm_resize_file_num" value="{{ $board_info->bm_resize_file_num }}" size="3"> (리사이징될 파일개수 - 원본제외)
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="bm_resize_file_size" id="bm_resize_file_size" value="{{ $board_info->bm_resize_file_size }}"> (리사이징될 파일사이즈 - '%%'구분자사용)
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>
            게시판 접근 권한설정
        </td>
        <td>
            <input type="text" name="bm_list_chk" id="bm_list_chk" value="{{ $board_info->bm_list_chk }}" size="3">목록
            <input type="text" name="bm_write_chk" id="bm_write_chk" value="{{ $board_info->bm_write_chk }}" size="3">쓰기
            <input type="text" name="bm_view_chk" id="bm_view_chk" value="{{ $board_info->bm_view_chk }}" size="3">보기
            <input type="text" name="bm_modify_chk" id="bm_modify_chk" value="{{ $board_info->bm_modify_chk }}" size="3">수정
            <input type="text" name="bm_delete_chk" id="bm_delete_chk" value="{{ $board_info->bm_delete_chk }}" size="3">삭제
            <input type="text" name="bm_reply_chk" id="bm_reply_chk" value="{{ $board_info->bm_reply_chk }}" size="3">답글
            <input type="text" name="bm_comment_chk" id="bm_comment_chk" value="{{ $board_info->bm_comment_chk }}" size="3">댓글<br>
            (비회원일때 100)
        </td>
    </tr>

    <tr>
        <td>
            카테고리 값
        </td>
        <td>
            <input type="text" name="bm_category_key" id="bm_category_key" value="{{ $board_info->bm_category_key }}"> (카테고리설정시 필요한 키값을 넣으세요..구분자 '%%'사용)
        </td>
    </tr>

    <tr>
        <td>
            카테고리 멘트
        </td>
        <td>
            <input type="text" name="bm_category_ment" id="bm_category_ment" value="{{ $board_info->bm_category_ment }}"> (카테고리키에 대응한 멘트를 넣으세요.구분자 '%%'사용 - 키와 개수가 같아야함)
        </td>
    </tr>

    <tr>
        <td>
            게시판 댓글 사용 여부
        </td>
        <td>
            @php
                if($board_info->bm_coment_type == 1) $checked = "checked";
                else $checked = "";
            @endphp

            <input type="checkbox" name="bm_coment_type" id="bm_coment_type" value="1" {{ $checked }}> (보기페이지에서 댓글 사용 여부)
        </td>
    </tr>

    <tr>
        <td>
            게시판 제목 길이
        </td>
        <td>
            <input type="text" name="bm_subject_len" id="bm_subject_len" value="{{ $board_info->bm_subject_len }}"> (게시물 리스트의 제목을 적당한 길이로 자름)
        </td>
    </tr>

    <tr>
        <td>
            페이지당 글수
        </td>
        <td>
            <input type="text" name="bm_record_num" id="bm_record_num" value="{{ $board_info->bm_record_num }}"> (한 페이지당 글 수를 지정)
        </td>
    </tr>

    <tr>
        <td>
            블럭당 페이지수
        </td>
        <td>
            <input type="text" name="bm_page_num" id="bm_page_num" value="{{ $board_info->bm_page_num }}"> (한 블럭당 페이지 수를 지정)
        </td>
    </tr>
    <tr>
        <td colspan=2>
            <button type="submit">저장</button>
        </td>

    </tr>
</form>
</table>




@endsection