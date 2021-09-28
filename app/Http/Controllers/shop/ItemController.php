<?php
#############################################################################
#
#		파일이름		:		ItemController.php
#		파일설명		:		카테고리별 상품 리스트 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 24일
#		최종수정일		:		2021년 09월 24일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id          = $request->input('ca_id');
        $length         = strlen($ca_id);

        //pgae 관련
        $pageNum     = $request->input('page');
        $writeList   = 15;  //페이지당 글수
        $pageNumList = 15; //블럭당 페이지수

        //검색 처리
        $keymethod      = $request->input('keymethod');
        $keyword        = $request->input('keyword');
        if($keymethod == "") $keymethod = "item_name";

        $tb_name = "items";
        $type = 'f_shopitems';
        $cate = "";

        $search_sql = "";
        if($keymethod != "" && $keyword != ""){
            $search_sql = " AND a.{$keymethod} LIKE '%{$keyword}%' ";
        }

        $page_control = CustomUtils::page_function('shopitems',$pageNum,$writeList,$pageNumList,$type,$tb_name,$ca_id,$keymethod,$keyword);

        if($ca_id == ""){
            $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_rank', 'DESC')->get();
            $item_infos = DB::select("select a.*, b.sca_id from shopitems a, shopcategorys b where a.item_display = 'Y' AND a.item_use = 1 AND a.sca_id = b.sca_id  {$search_sql} order by a.item_rank DESC limit {$page_control['startNum']}, {$writeList} ");

        }else{
            $down_cate = DB::table('shopcategorys')->where('sca_id','like',$ca_id.'%')->count();   //하위 카테고리 갯수
            if($down_cate != 1){
                $length = $length + 2;
                $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->where('sca_id','<>',$ca_id )->whereRaw('length(sca_id) = '.$length)->whereRaw("sca_id like '{$ca_id}%'")->orderby('sca_rank', 'DESC')->get();
            }else{  //하위 카테고리가 없을때 처리
                $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->where('sca_id','=',$ca_id )->whereRaw('length(sca_id) = '.$length)->whereRaw("sca_id like '{$ca_id}%'")->orderby('sca_rank', 'DESC')->get();
            }

            $item_infos = DB::select("select a.*, b.sca_id from shopitems a, shopcategorys b where a.item_display = 'Y' AND a.item_use = 1 AND a.sca_id = b.sca_id AND a.sca_id like '{$ca_id}%' {$search_sql} order by a.item_rank DESC limit {$page_control['startNum']}, {$writeList} ");
        }

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        $CustomUtils = new CustomUtils();
        return view('shop.item_page',[
            'ca_id'         => $ca_id,
            'cate_infos'    => $cate_infos,
            'item_infos'    => $item_infos,
            'pageList'      => $pageList,
            'keymethod'     => $keymethod,
            'keyword'       => $keyword,
            'totalCount'    => $page_control['totalCount'],
            'pageNum'       => $page_control['pageNum'],
            'pageList'      => $pageList,
            'CustomUtils'   => $CustomUtils,
        ]);
    }

    public function sitemdetail(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code          = $request->input('item_code');

        $item_info = DB::select("select a.*, b.sca_display from shopitems a, shopcategorys b where a.item_code = '$item_code' and a.sca_id = b.sca_id ");

        if(count($item_info) == 0){
            return redirect()->back()->with('alert_messages', $Messages::$shop['no_data']);
            exit;
        }

        //예외처리(카테고리 비출력, 상품 비출력, 판매 가능 여부)
        if($item_info[0]->sca_display == 'N' || $item_info[0]->item_display == 'N' || $item_info[0]->item_use == '0'){
            return redirect()->back()->with('alert_messages', $Messages::$shop['now_no_item']);
            exit;
        }

        //이미지 처리
        $j = 0;
        $p = 0;
        $big_img_disp = "";
        $small_img = array();

        for($i=1; $i<=10; $i++) {
            $item_img = "item_img".$i;

            if($item_info[0]->$item_img == "") continue;
            $j++;
            $item_img_cut = explode("@@",$item_info[0]->$item_img);

            if(count($item_img_cut) == 1) $item_img_disp = $item_img_cut[0];
            else $item_img_disp = $item_img_cut[1];

            if($j == 1){
                //큰이미지 출력
                $big_img_disp = "/data/shopitem/".$item_img_disp;
            }

            //작은 이미지 출력 배열
            $small_img_disp[$p] = "/data/shopitem/".$item_img_cut[3];
            $small_item_img[$p] = $i;
            $p++;
        }

        $CustomUtils = new CustomUtils();
        $use_point = $CustomUtils->setting_infos(); //환경 설정 포인트 설정

        //포인트 타입에 따른 변경
        $use_point_disp = "";
        if($use_point->company_use_point == 1){ //포인트 사용
            if($item_info[0]->item_point_type == 2){    //구매가 기준 설정비율
                $use_point_disp = "구매금액(추가옵션 제외)의 ".$item_info[0]->item_point."%";
            }else{
                $item_point = $CustomUtils->get_item_point($item_info[0]);
                $use_point_disp = number_format($item_point).'점';
            }
        }

        //배송비 타입에 따른 변경
        $sc_method_disp = "";
        if($item_info[0]->item_sc_type == 1) $sc_method_disp = '무료배송';
        else {
            if($item_info[0]->item_sc_method == 1) $sc_method_disp = '수령후 지불';
            else if($item_info[0]->item_sc_method == 2) {
                //$ct_send_cost_label = '<label for="ct_send_cost">배송비결제</label>';
                $sc_method_disp = '<select name="ct_send_cost" id="ct_send_cost">
                                        <option value="0">주문시 결제</option>
                                        <option value="1">수령후 지불</option>
                                   </select>';
            }else $sc_method_disp = '주문시 결제';
        }

        // 상품품절체크
        $is_soldout = $CustomUtils->is_soldout($item_info[0]->item_code);

        // 주문가능체크
        $is_orderable = true;

        if($item_info[0]->item_use != 1 || $item_info[0]->item_tel_inq == 1 || $is_soldout){
            $is_orderable = false;
        }

        $option_item = $supply_item = '';

        if($is_orderable){
            //선택 옵션
            $option_item = $CustomUtils->get_item_options($item_info[0]->item_code, $item_info[0]->item_option_subject, '');
            $supply_item = $CustomUtils->get_item_supply($item_info[0]->item_code, $item_info[0]->item_supply_subject, '');
        }


        return view('shop.item_detail',[
            "item_info"         => $item_info[0],
            "big_img_disp"      => $big_img_disp,
            "small_img_disp"    => $small_img_disp,
            "small_item_img"    => $small_item_img,
            "CustomUtils"       => $CustomUtils,
            "use_point"         => $use_point->company_use_point,
            "use_point_disp"    => $use_point_disp,
            "sc_method_disp"    => $sc_method_disp,

            "is_orderable"      => $is_orderable,   //재고가 있는지 파악 여부
            "option_item"       => $option_item,    //선택 옵션
            "supply_item"       => $supply_item,    //추가 옵션
        ]);
    }

    //ajax 큰이미지 변환
    public function ajax_big_img_change(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code  = $request->input('item_code');
        $item_img   = $request->input('item_img');

        $item_img_col = "item_img".$item_img;

        $img_serach = DB::table('shopitems')->select($item_img_col)->where('item_code',$item_code)->first();   //이미지 찾기
        $item_img_cut = explode("@@",$img_serach->$item_img_col);

        echo "/data/shopitem/".$item_img_cut[1];
    }

    //선택 옵션 ajax
    public function ajax_option_change(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code  = $request->input('item_code');
        $opt_id     = $request->input('opt_id');
        $idx        = $request->input('idx');
        $sel_count  = $request->input('sel_count');
        $op_title   = $request->input('op_title');

        $item_info = CustomUtils::get_shop_item($item_code);

        if(count($item_info) == 0){
            echo "No";
            exit;
        }

        $options = DB::table('shopitemoptions')->where([['sio_type','0'],['item_code',$item_code],['sio_use','1'],['sio_id','like',$opt_id.chr(30).'%']])->orderby('id', 'asc')->get();   //옵션 찾기
        $option_title = '선택';

        if( $op_title && ($op_title !== $option_title) && $item_info[0]->item_option_subject ){
            $array_tmps = explode(',', $item_info[0]->item_option_subject);
            if( isset($array_tmps[$idx+1]) && $array_tmps[$idx+1] ){
                $option_title = $array_tmps[$idx+1];
            }
        }

        $str = '<option value="">'.$option_title.'</option>';
        $opt = array();

        foreach($options as $option){
            $val = explode(chr(30), $option->sio_id);
            $key = $idx + 1;

            if(!strlen($val[$key])) continue;

            $continue = false;
            foreach($opt as $v) {
                if(strval($v) === strval($val[$key])) {
                    $continue = true;
                    break;
                }
            }

            if($continue) continue;

            $opt[] = strval($val[$key]);

            if($key + 1 < $sel_count) {
                $str .= PHP_EOL.'<option value="'.$val[$key].'">'.$val[$key].'</option>';
            } else {
                if($option->sio_price >= 0)
                    $price = '&nbsp;&nbsp;+ '.number_format($option->sio_price).'원';
                else
                    $price = '&nbsp;&nbsp; '.number_format($option->sio_price).'원';

                $sio_stock_qty = CustomUtils::get_option_stock_qty($item_code, $option->sio_id, $option->sio_type);

                if($sio_stock_qty < 1)
                    $soldout = '&nbsp;&nbsp;[품절]';
                else
                    $soldout = '';

                $str .= PHP_EOL.'<option value="'.$val[$key].','.$option->sio_price.','.$sio_stock_qty.'">'.$val[$key].$price.$soldout.'</option>';
            }
        }

        echo $str;
    }



}
