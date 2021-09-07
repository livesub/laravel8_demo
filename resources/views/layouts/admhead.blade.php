@php
header ('Pragma: no-cache');
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
header('Pragma: public');
@endphp

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <title>ADIMISTRATOR</title>
</head>
<body>

<script src='//code.jquery.com/jquery-3.3.1.min.js'></script>

    <table>
        <tr>
            <td>
            @if(auth()->user())
            <a href='{{ route('logout.destroy') }}'>LOGOUT</a>
            @endif
            </td>
        </tr>
    </table>

    <table border="1">
        <tr>
            <td>상단 메뉴 또는 타이틀 등등</td>
        </tr>
    </table>
    <table border="1">
        <tr>
            <td>
                <table>
                    <tr>
                        <td><a href="{{ route('adm.member.index') }}">회원 관리</a></td>
                    </tr>

                    <tr>
                        <td><a href="{{ route('adm.admemail.index') }}">회원 이메일 발송 관리</a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ route('adm.popup.index') }}">팝업 관리</a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ route('adm.boardmanage.index') }}">게시판 관리</a></td>
                    </tr>
                    <tr>
                        <td><br><a href="{{ route('adm.cate.index') }}">카테고리 관리</a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ route('adm.item.index') }}">상품 관리</a></td>
                    </tr>


                    <tr>
                        <td><a href="{{ route('adm.menu.index') }}"><br>메뉴 관리</a></td>
                    </tr>

                    <tr>
                        <td><br><br><br>게시판 리스트</td>
                    </tr>
                    @php
                        $b_lists = DB::table('boardmanagers')->select('id', 'bm_tb_name', 'bm_tb_subject')->orderBy('id', 'desc')->get();
                    @endphp

                    @foreach($b_lists as $b_list)
                    <tr>
                        <td><a href="{{ route('adm.admboard.index',$b_list->bm_tb_name) }}"> - {{ $b_list->bm_tb_subject }}</a></td>
                    </tr>
                    @endforeach

                    <tr>
                        <td><br><br><br>통계</td>
                    </tr>
                    <tr>
                        <td><a href="{{ route('adm.visit.memberindex') }}">회원 로그인 통계</a></td>
                    </tr>

                    <tr>
                        <td><a href="{{ route('adm.visit.index') }}">방문자 통계</a></td>
                    </tr>

                    <tr>
                        <td><br><a href="{{ route('adm.editor.delete') }}">에디터 불필요 파일 삭제</a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ route('adm.session_del.destroy') }}">세션 파일 일괄 삭제</a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ url('adm/clear-cache') }}">캐시 파일 일괄 삭제</a></td>
                    </tr>
                    <tr>
                        <td><br><br>쇼핑몰</td>
                    </tr>
                    <tr>
                        <td><a href="{{ route('shop.cate.index') }}">분류 관리</a></td>
                    </tr>
                </table>
            </td>

            <td>
                <table>
                    <tr>
                        <td>
                            {{-- 각 내용 뿌리기 --}}
                            @yield('content')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>





    {{-- alert_messages Error --}}
    @if (Session::has('alert_messages'))
    <script>
        alert('{!! Session::get('alert_messages') !!}');
    </script>
    @endif

</body>
</html>
