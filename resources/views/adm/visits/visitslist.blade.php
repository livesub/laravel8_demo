@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>방문자 통계 리스트</h4></td>
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
        <td>City</td>
        <td>Country</td>
        <td>Browser</td>
        <td>OS</td>
        <td>Device</td>
        <td>Referer</td>
        <td>Agent</td>
    </tr>

    @foreach($visits as $visit)
    <tr>
        <td>{{ $virtual_num-- }}</td>
        <td>{{ $visit->vi_ip }}</td>
        <td>{{ $visit->vi_city }}</td>
        <td>{{ $visit->vi_country }}</td>
        <td>{{ $visit->vi_browser }}</td>
        <td>{{ $visit->vi_os }}</td>
        <td>{{ $visit->vi_device }}</td>
        <td>{{ $visit->vi_referer }}</td>
        <td>{{ $visit->vi_agent }}</td>
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
