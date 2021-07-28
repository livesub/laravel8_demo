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
        <td>게시판종류</td>
        <td>
            @php
            if($board_info->bm_type == 1){
                $bm_type1 = "selected";
                $bm_type2 = "";
            }else if($board_info->bm_type == 2){
                $bm_type1 = "";
                $bm_type2 = "selected";
            }
            @endphp
            <select name="bm_type" id="bm_type">

                <option value="1" {{ $bm_type1 }}>일반게시판</option>
                <option value="2" {{ $bm_type2 }}>갤러리게시판</option>
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
                        <input type="text" name="bm_resize_width_file" id="bm_resize_width_file" value="{{ $board_info->bm_resize_width_file }}"> (리사이징될 파일 넓이 - '%%'구분자사용)<br>
                        <input type="text" name="bm_resize_height_file" id="bm_resize_height_file" value="{{ $board_info->bm_resize_height_file }}"> (리사이징될 파일 높이 - '%%'구분자사용)
                    </td>
                </tr>
                <tr>
                    <td><font color="red">※ 리사이징 파일 갯수를 지정 했을시 넓이와 높이를 꼭 지정 하세요.</font></td>
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
            <br>
            (비회원일때 100, 관리자 일땐 3 이하를 적어 주세요.)
        </td>
    </tr>

    <tr>
        <td>
            카테고리 값
        </td>
        <td>
            <input type="text" name="bm_category_key" id="bm_category_key" value="{{ $board_info->bm_category_key }}"> (카테고리설정시 필요한 키값을 넣으세요..구분자 '@@'사용)
        </td>
    </tr>

    <tr>
        <td>
            카테고리 멘트
        </td>
        <td>
            <input type="text" name="bm_category_ment" id="bm_category_ment" value="{{ $board_info->bm_category_ment }}"> (카테고리키에 대응한 멘트를 넣으세요.구분자 '@@'사용 - 키와 개수가 같아야함)
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

            <input type="checkbox" name="bm_coment_type" id="bm_coment_type" value="1" {{ $checked }}> (보기페이지에서 댓글 사용 여부 - 사용시 회원만 댓글 가능 합니다.)
        </td>
    </tr>
    <tr>
        <td>
            게시판 비밀글 사용 여부
        </td>
        <td>
            @php
                if($board_info->bm_secret_type == 1) $checked = "checked";
                else $checked = "";
            @endphp

            <input type="checkbox" name="bm_secret_type" id="bm_secret_type" value="1" {{ $checked }}> (비밀글 사용 여부)
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