@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>회원 로그인 통계 리스트</h4></td>
    </tr>
</table>
<table border=1>
    <tr>
        <td>
            <table border=1>
                <tr>
                    <td>전체 : {{ $totalCount }}</td>
                    <td>오늘 : {{ $today }}</td>
                    <td>어제 : {{ $yesterday }}</td>
                </tr>
            </table>
        </td>
        <td>회원 로그인 통계 삭제</td>
        <td>
            <table border=1>
            <form name="del_form" id="del_form" method="post" action='{{ route('adm.membervisit_del') }}'>
            {!! csrf_field() !!}
                <tr>
                    <td>년도선택 :
                        <select name="year" id="year">
                            <option value="">년도선택</option>

                            @for($year = $min_year; $year <= $now_year; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endfor

                        </select>
                    </td>
                    <td>월선택 :
                        <select name="month" id="month">
                            <option value="">월선택</option>

                            @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor

                        </select>
                    </td>
                    <td>삭제방법선택 :
                        <select name="method" id="method">
                            <option value="before">선택년월 이전 자료삭제</option>
                            <option value="specific">선택년월의 자료삭제</option>
                        </select>
                    </td>
                    <td><button type="button" onclick="mem_visits_del();">삭제</button></td>
                </tr>
            </form>
            </table>
        </td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>순번</td>
        <td>아이피</td>
        <td>아이디</td>
        <td>이름</td>
        <td>City</td>
        <td>Country</td>
        <td>Browser</td>
        <td>OS</td>
        <td>Device</td>
        <td>Referer</td>
        <td>Agent</td>
        <td>로그인시간</td>
    </tr>

    @foreach($membervisits as $membervisit)
        @php
            $user_info = DB::table('users')->select('user_id','user_name','user_phone')->where('user_id',$membervisit->user_id)->first();
        @endphp
    <tr>
        <td>{{ $virtual_num-- }}</td>
        <td>{{ $membervisit->mv_ip }}</td>
        <td>{{ $user_info->user_id }}</td>
        <td>{{ $user_info->user_name }}</td>
        <td>{{ $membervisit->mv_city }}</td>
        <td>{{ $membervisit->mv_country }}</td>
        <td>{{ $membervisit->mv_browser }}</td>
        <td>{{ $membervisit->mv_os }}</td>
        <td>{{ $membervisit->mv_device }}</td>
        <td>{{ $membervisit->mv_referer }}</td>
        <td>{{ $membervisit->mv_agent }}</td>
        <td>{{ $membervisit->created_at }}</td>
    </tr>
    @endforeach
</table>

<table>
    <tr>
        <td>
           {!! $pageList !!}
        </td>
    </tr>
</table>



<script>
    function mem_visits_del(){
        var year = $("#year option:selected").val();
        var month = $("#month option:selected").val();

        if(year == ""){
            alert("년도를 선택 하세요.");
            $("#year").focus();
            return false;
        }

        if(month == ""){
            alert("월을 선택 하세요.");
            $("#month").focus();
            return false;
        }

        if (confirm("선택 하신 년/월 통계를 삭제 하시겠습니까?") == true){    //확인
            $("#del_form").submit();
        }else{
            return false;
        }
    }
</script>




@endsection
