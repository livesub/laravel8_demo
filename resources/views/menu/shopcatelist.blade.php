@if(count($one_step_infos) != 0)
<style>
/*세로형 메뉴*/
#menu2 {
    border-left: 10px solid black;
}

#menu2 a {
    display: block;
    color: #fff;
}

.M01 {
    margin-left: 20px;
    width: 100px;
    background: #000;
}

.M01>li, .M02>li, .M03>li {
    position: relative;
    width: 100px;
    height: 50px;
    background: #000;
    text-align: center;
    line-height: 50px;
}

.M01>li:hover .M02 {
    left: 100px;
}

.M01>li a:hover {
    display: block;
    background: #AB06AD;
}

.M02, .M03 {
    width: 100px;
    background: black;
    position: absolute;
    top: 0;
    left: -9999px;
}

.M02>li:hover .M03 {
    left: 100px;
}

.M02>li a:hover {
    display: block;
    background: red;
}

.M03>li a:hover {
    display: block;
    background: blue;
}
</style>


<div id="menu2">
    <ul class="M01">
        @foreach($one_step_infos as $one_step_info)
            @php
                $two_step_infos = DB::table('shopcategorys')->where('sca_display','Y')->where([['sca_display','Y'],['sca_id', 'LIKE', $one_step_info->sca_id.'%'],['sca_id', '!=',$one_step_info->sca_id]])->whereRaw('length(sca_id) = 4')->orderby('sca_rank', 'DESC')->get();   //정보 읽기
            @endphp
        <li><a href="{{ route('sitem','ca_id='.$one_step_info->sca_id) }}">{{ $one_step_info->sca_name_kr }}</a>

            @if(count($two_step_infos) != 0)

            <ul class="M02">

                @foreach($two_step_infos as $two_step_info)
                    @php
                        $three_step_infos = DB::table('shopcategorys')->where('sca_display','Y')->where([['sca_display','Y'],['sca_id', 'LIKE', $two_step_info->sca_id.'%'],['sca_id', '!=',$two_step_info->sca_id]])->whereRaw('length(sca_id) = 6')->orderby('sca_rank', 'DESC')->get();   //정보 읽기
                    @endphp
                <li><a href="{{ route('sitem','ca_id='.$two_step_info->sca_id) }}">{{ $two_step_info->sca_name_kr }}</a>

                    @if(count($three_step_infos) != 0)

                    <ul class="M03">
                        @foreach($three_step_infos as $three_step_info)
                        <li><a href="{{ route('sitem','ca_id='.$three_step_info->sca_id) }}">{{ $three_step_info->sca_name_kr }}</a></li>
                        @endforeach
                    </ul>

                    @endif

                </li>
                @endforeach
            </ul>
            @endif

        </li>
        @endforeach

    </ul>
</div>
@endif
