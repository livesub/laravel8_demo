<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <title>ADIMISTRATOR</title>
</head>
<body>

<script src='//code.jquery.com/jquery-3.3.1.min.js'></script>
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
                        <td><a href="/adm/member">회원 관리</a></td>
                    </tr>
                    <tr>
                        <td><a href="/adm/boardmanage">게시판 관리</a></td>
                    </tr>
                    <tr>
                        <td>게시판 리스트</td>
                    </tr>
                    @php
                        $b_lists = DB::table('boardmanagers')->select('id', 'bm_tb_name', 'bm_tb_subject')->orderBy('id', 'desc')->get();
                    @endphp

                    @foreach($b_lists as $b_list)
                    <tr>
                        <td><a href="/adm/admboard/list/{{ $b_list->bm_tb_name }}"> - {{ $b_list->bm_tb_subject }}</a></td>
                    </tr>
                    @endforeach

                    <tr>
                        <td><a href="/adm/editor">에디터 불필요 파일 삭제</a></td>
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
