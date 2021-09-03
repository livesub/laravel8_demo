<!-- 팝업레이어 시작 { -->
<div id="hd_pop">
@foreach($pop_lists as $pop_list)
    @php
        if(isset($_COOKIE["hd_pops_{$pop_list->id}"]) && $_COOKIE["hd_pops_{$pop_list->id}"]) continue;
    @endphp

    <div id="hd_pops_{{ $pop_list->id }}" class="hd_pops" style="top:{{ $pop_list->pop_top }}px;left:{{ $pop_list->pop_left }}px" >
        <div class="hd_pops_con" style="width:{{ $pop_list->pop_width }}px;height:{{ $pop_list->pop_height }}px">
            {!! $pop_list->pop_content !!}
        </div>
        <div class="hd_pops_footer">
            <button class="hd_pops_reject hd_pops_{{ $pop_list->id }} {{ $pop_list->pop_disable_hours }}"><strong>{{ $pop_list->pop_disable_hours }}</strong>시간 동안 다시 열람하지 않습니다.</button>
            <button class="hd_pops_close hd_pops_{{ $pop_list->id }}">닫기 <i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    </div>
@endforeach



<style>
#hd_pop {z-index:1000;position:relative;margin:0 auto;height:0}
#hd_pop h2 {position:absolute;font-size:0;line-height:0;overflow:hidden}
.hd_pops {position:absolute;border:1px solid #e9e9e9;background:#fff}
.hd_pops img {max-width:100%}
.hd_pops_con {}
.hd_pops_footer {padding:0;background:#000;color:#fff;text-align:left;position:relative}
.hd_pops_footer:after {display:block;visibility:hidden;clear:both;content:""}
.hd_pops_footer button {padding:10px;border:0;color:#fff}
.hd_pops_footer .hd_pops_reject {background:#000;text-align:left}
.hd_pops_footer .hd_pops_close {background:#393939;position:absolute;top:0;right:0}
</style>

<script>
$(function() {
    $(".hd_pops_reject").click(function() {
        var id = $(this).attr('class').split(' ');
        var ck_name = id[1];
        var exp_time = parseInt(id[2]);
        $("#"+id[1]).css("display", "none");
        set_cookie(ck_name, 1, exp_time, '/');
    });

    $('.hd_pops_close').click(function() {
        var idb = $(this).attr('class').split(' ');
        $('#'+idb[1]).css('display','none');
    });

    $("#hd").css("z-index", 1000);
});
</script>

<script>
function set_cookie(name, value, expirehours, domain)
{
    var today = new Date();
    today.setTime(today.getTime() + (60*60*1000*expirehours));
    document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
    if (domain) {
        document.cookie += "domain=" + domain + ";";
    }
}
</script>
<!-- } 팝업레이어 끝 -->