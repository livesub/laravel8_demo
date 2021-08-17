@php
    use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
@endphp

<style>
/*가로메뉴형*/
#menu {
    height: 50px;
    background: #fcc;
}

.main1 {
    width: 600px;
    height: 100%;
    margin: 0 auto;
}

.main1>li {
    float: left;
    width: 25%;
    line-height: 50px;
    text-align: center;
    position: relative;
}

.main1>li:hover .main2 {
    left: 0;
}

.main1>li a {
    display: block;
}

.main1>li a:hover {
    background: #B21016;
    color: #fff;
    font-weight: bold;
}

.main2 {
    position: absolute;
    top: 50px;
    left: -9999px;
    background: #ccc;
    width: 120%;
}

.main2>li {
    position: relative;
}

.main2>li:hover .main3 {
    left: 100%;
}

.main2>li a, .main3>li a {
    border-radius: 10px;
    margin: 10px;
}

.main3 {
    position: absolute;
    top: 0;
    background: #6BD089;
    width: 80%;
    left: -9999px;
    /*left: 100%;*/
    /*display: none;*/
}

.main3>li a:hover {
    background: #085820;
    color: #fff;
}
</style>

@php
    $one_step_infos = DB::table('menuses')->where('menu_display','Y')->whereRaw('length(menu_id) = 2')->orderby('menu_rank', 'DESC')->get();   //정보 읽기
@endphp

    @if(count($one_step_infos) != "0")
    <table>
        <tr>
            <td>
                <div id="menu">
                    <ul class="main1">
                        @foreach($one_step_infos as $one_step_info)
                            @php
                                $one_page_link = "";
                                $two_step_infos = DB::table('menuses')->where('menu_display','Y')->whereRaw("menu_id like '{$one_step_info->menu_id}%'")->whereRaw('length(menu_id) = 4')->orderby('menu_rank', 'DESC')->get();   //정보 읽기
                                $one_page_link = CustomUtils::menu_page_link2($one_step_info);
                            @endphp

                        <li>
                            <a href="{{ $one_page_link }}">{{ $one_step_info->menu_name_kr }}</a>

                            @if($one_step_info->menu_page_type == "I")  <!-- 상품 일때 처리 -->
                                @php
                                    $cate_infos = DB::table('categorys')->select('ca_id', 'ca_name_kr', 'ca_name_en')->where('ca_display','Y')->whereRaw('length(ca_id) = 2')->orderby('ca_rank', 'DESC')->get();
                                @endphp
                            <ul class="main2">
                                @foreach($cate_infos as $cate_info)
                                <li><a href="{{ route('item.index','ca_id='.$cate_info->ca_id) }}">{{ $cate_info->ca_name_kr }}</a>
                                </li>
                                @endforeach
                            </ul>
                            @endif


                            @if(count($two_step_infos) != 0)

                            <ul class="main2">

                                @foreach($two_step_infos as $two_step_info)
                                    @php
                                        $two_page_link = "";
                                        $three_step_infos = DB::table('menuses')->where('menu_display','Y')->whereRaw("menu_id like '{$two_step_info->menu_id}%'")->whereRaw('length(menu_id) = 6')->orderby('menu_rank', 'DESC')->get();   //정보 읽기

                                        //$two_page_link = CustomUtils::menu_page_link($three_step_infos,$two_step_info);
                                        $two_page_link = CustomUtils::menu_page_link2($two_step_info);
                                    @endphp

                                <li><a href="{{ $two_page_link }}">{{ $two_step_info->menu_name_kr }}</a>

                                    @if(count($three_step_infos) != 0)

                                    <ul class="main3">

                                        @foreach($three_step_infos as $three_step_info)
                                        @php
                                            //$three_page_link = CustomUtils::menu_page_link($three_step_infos,$three_step_info);
                                            $three_page_link = CustomUtils::menu_page_link2($three_step_info);
                                        @endphp

                                        <li><a href="{{ $three_page_link }}">{{ $three_step_info->menu_name_kr }}</a></li>
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

            </td>
        </tr>
    </table>
    @endif
