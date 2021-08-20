@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>회원 이메일 발송 명단</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>번호</td>
        <td>사진</td>
        <td>이름</td>
        <td>아이디(이메일)</td>
        <td>전화번호</td>
        <td>발송일</td>
        <td>발송 실패 여부</td>
        <td>메일 확인 여부</td>
        <td>메일 확인일</td>
    </tr>
    @foreach($email_send_lists as $email_send_list)
        @php
            $user_info = DB::table('users')->select('id','user_id','user_name','user_phone','user_imagepath')->where('user_id',$email_send_list->email_user_id)->first();
        @endphp
    <tr>
        <td>{{ $virtual_num-- }}</td>
        <td>
        @if($user_info->user_imagepath)
            <img src='{{ asset('/data/member/'.$user_info->user_imagepath) }}' style='border-radius: 50%;width:40px;height:40px;'>
        @endif
        </td>
        <td>{{ $user_info->user_name }}</td>
        <td>{{ $user_info->user_id }}</td>
        <td>{{ $user_info->user_phone }}</td>
        <td>{{ $email_send_list->created_at }}</td>
        <td>
            @if($email_send_list->email_send_chk == 'Y')
                성공
            @else
                실패
            @endif
        </td>
        <td>
            @if($email_send_list->email_receive_chk == 'Y')
                확인
            @else
                <font color='blue'>미확인</font>
            @endif
        </td>
        <td>
            @if($email_send_list->email_receive_chk == 'Y')
                {{ $email_send_list->updated_at }}
            @endif
        </td>
    </tr>
    @endforeach
    <tr>
</table>

<table>
    <tr>
        <td>{!! $pageList !!}</td>
    </tr>
</table>




@endsection
