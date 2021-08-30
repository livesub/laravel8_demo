@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>회원 로그인 통계 리스트</h4></td>
    </tr>
</table>
<table border=1>
    <tr>
        <td>전체 : {{ $totalCount }}</td>
        <td>오늘 : {{ $today }}</td>
        <td>어제 : {{ $yesterday }}</td>
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




@endsection
