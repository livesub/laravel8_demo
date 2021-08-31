@php
header ('Pragma: no-cache');
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
header('Pragma: public');

//방문 통계 호출
use App\Http\Controllers\statistics\StatisticsController;
$statistics = new StatisticsController();
$statistics->statistics();
@endphp

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <title>dev_board</title>
</head>
<body>

<script src='//code.jquery.com/jquery-3.3.1.min.js'></script>

<script>
    function multi_lang()
    {
        var multilingual = $('#multi_lang').val();
        location.href = '{{ url('multilingual') }}/'+multilingual;
    }
</script>

    <div class='form-group'>
        <select name='multi_lang' id='multi_lang' onchange='multi_lang();'>
            <option value='kr'
            @if(Session::get('multi_lang') == '' || Session::get('multi_lang') == 'kr')
                selected
            @endif
            >Korea</option>
            <option value='en'
            @if(Session::get('multi_lang') == 'en')
                selected
            @endif
            >Englsh</option>
        </select>
    </div>

    <table>
        <tr>
            <td>
            @if(!auth()->user())
                <a href='{{ route('login.index') }}'>LOGIN</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='{{ route('join.create') }}'>REGISTER</a>
            @else
                <a href='{{ route('mypage.index') }}'>MYPAGE</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='{{ route('logout.destroy') }}'>LOGOUT</a>
            @endif
            </td>


            @if(auth()->user())
                @if(Auth::user()->user_level <= config('app.ADMIN_LEVEL'))
            <td>
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='{{ route('adm.index') }}'>관리자</a>
            </td>
                @endif
            @endif
        </tr>
    </table>

<!-- 메뉴 불러 오기 -->
    @include('head_menu')
<!-- 메뉴 불러 오기 -->
<!--
    <table>

        <tr>
            <td>
                <table border=1>
                    <tr>
                    @php
                        $b_lists = DB::table('boardmanagers')->select('id', 'bm_tb_name', 'bm_tb_subject')->orderBy('id', 'desc')->get();
                    @endphp

                    @foreach($b_lists as $b_list)
                        <td><a href="/board/list/{{ $b_list->bm_tb_name }}"> {{ $b_list->bm_tb_subject }}</a></td>
                    @endforeach
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td>제품 소개</td>
        </tr>
        <tr>
            <td>
                <table border=1>
                    <tr>
                    @php
                        $cate_lists = DB::table('categorys')->select('id', 'ca_id', 'ca_name_kr')->where('ca_display','Y')->whereRaw("length(ca_id) = '2'")->orderBy('ca_rank', 'desc')->get();
                    @endphp

                    @foreach($cate_lists as $cate_list)
                        <td>{{ $cate_list->ca_name_kr }}</td>
                    @endforeach
                    </tr>
                </table>
            </td>
        </tr>

    </table>
-->


    {{-- 각 내용 뿌리기 --}}
    @yield('content')






    {{-- alert_messages Error --}}
    @if (Session::has('alert_messages'))
    <script>
        alert('{!! Session::get('alert_messages') !!}');
    </script>
    @endif

</body>
</html>
