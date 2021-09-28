<?php
#############################################################################
#
#		파일이름		:		AdmShopItemController.php
#		파일설명		:		관리자 쇼핑몰 상품 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 13일
#		최종수정일		:		2021년 09월 13일
#
###########################################################################-->

namespace App\Http\Controllers\adm\shop\item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\shopcategorys;    //카테고리 모델 정의
use App\Models\shopitems;    //상품 모델 정의
use App\Models\shopitemoptions;    //상품 옵션 모델 정의
use Validator;  //체크

class AdmShopItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $pageNum     = $request->input('page');
        $writeList   = 20;  //페이지당 글수
        $pageNumList = 20; //블럭당 페이지수

        $tb_name = "shopitems";
        $type = 'shopitems';
        $cate = "";

        //검색 selectbox 만들기
        $search_selectboxs = DB::table('shopcategorys')->orderby('sca_id','ASC')->orderby('sca_rank','DESC')->get();

        //검색 처리
        $ca_id          = $request->input('ca_id');
        $item_search    = $request->input('item_search');
        $keyword        = $request->input('keyword');

        if($item_search == "") $item_search = "item_name";

        $search_caid_sql = "";
        if(!is_null($ca_id)){
            $search_caid_sql = " AND a.sca_id like '{$ca_id}%' ";
        }

        $search_sql = "";
        if($item_search != ""){
            //$search_sql = " AND a.sca_id = b.sca_id {$search_caid_sql} AND a.sca_id LIKE '{$cate_search}%' AND a.{$item_search} LIKE '%{$keyword}%' ";
            $search_sql = " AND a.sca_id = b.sca_id {$search_caid_sql} AND a.{$item_search} LIKE '%{$keyword}%' ";
        }else{
            //$search_sql .= " AND a.sca_id = b.sca_id {$search_caid_sql} AND a.{$item_search} LIKE '%{$keyword}%' ";
            $search_sql = " AND a.sca_id = b.sca_id {$search_caid_sql} ";
        }

        $page_control = CustomUtils::page_function('shopitems',$pageNum,$writeList,$pageNumList,$type,$tb_name,$ca_id,$item_search,$keyword);

        $item_infos = DB::select("select a.*, b.sca_id from shopitems a, shopcategorys b where 1 {$search_sql} order by a.id DESC, a.item_rank ASC limit {$page_control['startNum']}, {$writeList} ");

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.shop.item.itemlist',[
            'ca_id'             => $ca_id,
            'item_infos'        => $item_infos,
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
            'item_search'       => $item_search,
            'keyword'           => $keyword,
            'search_selectboxs' => $search_selectboxs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id     = $request->input('sca_id');

        //환경 설정 DB에서 이미지 리사이징 값이 있는 지 파악
        $resiz_result = CustomUtils::resize_chk();

        if(!$resiz_result){
            return redirect(route('shop.setting.index'))->with('alert_messages', $Messages::$shop['no_resize']);  //치명적인 에러가 있을시
            exit;
        }

        //1단계 가져옴
        $one_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_id', 'ASC')->get();

        //2단계 가져옴
        $two_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 4')->orderby('sca_id', 'ASC')->get();

        //3단계 가져옴
        $three_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 6')->orderby('sca_id', 'ASC')->get();

        //4단계 가져옴
        $four_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 8')->orderby('sca_id', 'ASC')->get();

        //5단계 가져옴
        $five_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 10')->orderby('sca_id', 'ASC')->get();

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $item_directory = "data/shopitem/editor";
        setcookie('directory', $item_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        //첨부 파일 저장소
        $target_path = "data/shopitem";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        return view('adm.shop.item.itemcreate',[
            'item_code'         => "sitem_".time(),
            'ca_id'             => $ca_id,
            'one_step_infos'    => $one_step_infos,
            'two_step_infos'    => $two_step_infos,
            'three_step_infos'  => $three_step_infos,
            'four_step_infos'   => $four_step_infos,
            'five_step_infos'   => $five_step_infos,
        ]);
    }

    public function ajax_select(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id     = $request->input('ca_id');

        $length     = $request->input('length');

        if($ca_id == "" && $length == ""){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        $qry = "";
        if($ca_id != ""){
            if($length == '2'){
                $qry = "SELECT sca_id, sca_name_kr, sca_name_en FROM shopcategorys WHERE sca_id like '{$ca_id}%' and sca_id != '{$ca_id}' and length(sca_id) = '4' and sca_display = 'Y' ";
            }elseif($length == '4'){
                $qry = "SELECT sca_id, sca_name_kr, sca_name_en FROM shopcategorys WHERE sca_id like '{$ca_id}%' and sca_id != '{$ca_id}' and length(sca_id) = '6' and sca_display = 'Y' ";
            }elseif($length == '6'){
                $qry = "SELECT sca_id, sca_name_kr, sca_name_en FROM shopcategorys WHERE sca_id like '{$ca_id}%' and sca_id != '{$ca_id}' and length(sca_id) = '8' and sca_display = 'Y' ";
            }elseif($length == '8'){
                $qry = "SELECT sca_id, sca_name_kr, sca_name_en FROM shopcategorys WHERE sca_id like '{$ca_id}%' and sca_id != '{$ca_id}' and length(sca_id) = '10' and sca_display = 'Y' ";
            }elseif($length == '10'){
                $qry = "SELECT sca_id, sca_name_kr, sca_name_en FROM shopcategorys WHERE sca_id like '{$ca_id}%' and sca_id != '{$ca_id}' and length(sca_id) = '12' and sca_display = 'Y' ";
            }
        }

        $cate_infos = DB::select($qry);
        $num_rows = count($cate_infos);

        $output = "";
        if($num_rows > 0){
            if($length == '2'){
                $output = '<select name="ca_id" size="10" id="caa_id2"class="cid"  >';
            }elseif($length == '4'){
                $output = '<select name="ca_id" size="10" id="caa_id3"class="cid" >';
            }elseif($length == '6'){
                $output = '<select name="ca_id" size="10" id="caa_id4"class="cid" >';
            }elseif($length == '8'){
                $output = '<select name="ca_id" size="10" id="caa_id5"class="cid" >';
            }elseif($length == '10'){
                $output = '<select name="ca_id" size="10" id="caa_id6"class="cid" >';
            }

            foreach($cate_infos as $cate_info){
                $output .= '<option value="'.$cate_info->sca_id.'">'.$cate_info->sca_name_kr.'</option>';
            }
            $output .= '</select>';
        }

        if($cate_infos == null) $ca_name_kr = "";
        else $ca_name_kr = $cate_info->sca_name_kr;

        return response()->json(['success' => '1','data' => $output, 'ca_id' => $ca_id], 200, [], JSON_PRETTY_PRINT);
        exit;
    }

    public function createsave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        if(!isset($_COOKIE['directory'])){  //쿠키 값이 사라진 후에 저장 되지 않게
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        //환경 설정 DB에서 이미지 리사이징 값이 있는 지 파악
        $resiz_result = CustomUtils::resize_chk();

        if(!$resiz_result){
            return redirect(route('shop.setting.index'))->with('alert_messages', $Messages::$shop['no_resize']);  //치명적인 에러가 있을시
            exit;
        }
dd($resiz_result['shop_img_height']);
        $ca_id                  = $request->input('ca_id');
        $item_code              = $request->input('item_code');
        $item_name              = addslashes($request->input('item_name'));
        $item_basic             = $request->input('item_basic');
        $item_manufacture       = $request->input('item_manufacture');
        $item_origin            = $request->input('item_origin');
        $item_brand             = $request->input('item_brand');
        $item_model             = $request->input('item_model');
        $item_option_subject    = $request->input('item_option_subject');
        $item_supply_subject    = $request->input('item_supply_subject');
        $item_type1             = (int)$request->input('item_type1');
        $item_type2             = (int)$request->input('item_type2');
        $item_type3             = (int)$request->input('item_type3');
        $item_type4             = (int)$request->input('item_type4');
        $item_content           = $request->input('item_content');
        $item_cust_price        = (int)$request->input('item_cust_price');
        $item_price             = (int)$request->input('item_price');
        $item_point_type        = (int)$request->input('item_point_type');
        $item_point             = (int)$request->input('item_point');
        $item_supply_point      = (int)$request->input('item_supply_point');
        $item_use               = (int)$request->input('item_use');
        $item_nocoupon          = (int)$request->input('item_nocoupon');
        $item_soldout           = (int)$request->input('item_soldout');
        $item_stock_qty         = $request->input('item_stock_qty');
        $item_sc_type           = $request->input('item_sc_type');
        $item_sc_method         = $request->input('item_sc_method');
        $item_sc_price          = $request->input('item_sc_price');
        $item_sc_minimum        = $request->input('item_sc_minimum');
        $item_sc_qty            = $request->input('item_sc_qty');
        $item_tel_inq           = (int)$request->input('item_tel_inq');
        $item_display           = $request->input('item_display');
        $item_rank              = (int)$request->input('item_rank');
        $length                 = (int)$request->input('length');
        $last_choice_ca_id      = $request->input('last_choice_ca_id');

        $item_option_subject = '';
        $item_supply_subject = '';

        if(is_null($ca_id) || is_null($item_code) || is_null($item_name)){
            return redirect(route('shop.item.index'))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        /***** 옵션 처리  ***/
        //옵션 상품 처리
        $opt_id         = $request->input('opt_id');
        $opt_price      = $request->input('opt_price');
        $opt_stock_qty  = $request->input('opt_stock_qty');
        $opt_noti_qty   = $request->input('opt_noti_qty');
        $opt_use        = $request->input('opt_use');
        $opt1_subject   = $request->input('opt1_subject');
        $opt2_subject   = $request->input('opt2_subject');
        $opt3_subject   = $request->input('opt3_subject');

        $option_count = (isset($opt_id) && is_array($opt_id)) ? count($opt_id) : array();

        //선택옵션등록
        if($option_count) {
            // 옵션명
            $opt1_cnt = $opt2_cnt = $opt3_cnt = 0;
            for($i=0; $i<$option_count; $i++) {
                $post_opt_id = strip_tags($opt_id[$i]);

                $opt_val = explode(chr(30), $post_opt_id);
                if(isset($opt_val[0]) && $opt_val[0])
                    $opt1_cnt++;
                if(isset($opt_val[1]) && $opt_val[1])
                    $opt2_cnt++;
                if(isset($opt_val[2]) && $opt_val[2])
                    $opt3_cnt++;
            }

            if($opt1_subject && $opt1_cnt) {
                $item_option_subject = $opt1_subject;
                if($opt2_subject && $opt2_cnt)
                    $item_option_subject .= ','.$opt2_subject;
                if($opt3_subject && $opt3_cnt)
                    $item_option_subject .= ','.$opt3_subject;
            }

            for($i=0; $i<$option_count; $i++) {
                //DB 저장 배열 만들기
                $optdata = array(
                    'sio_id'        => $opt_id[$i],
                    'sio_type'      => 0,
                    'item_code'     => $item_code,
                    'sio_price'     => $opt_price[$i],
                    'sio_stock_qty' => $opt_stock_qty[$i],
                    'sio_noti_qty'  => $opt_noti_qty[$i],
                    'sio_use'       => $opt_use[$i],
                );

                //저장 처리
                $optcreate_result = shopitemoptions::create($optdata);
                $optcreate_result->save();
            }
        }

        // 추가옵션 처리
        $spl_id         = $request->input('spl_id');
        $spl_price      = $request->input('spl_price');
        $spl_stock_qty  = $request->input('spl_stock_qty');
        $spl_noti_qty   = $request->input('spl_noti_qty');
        $spl_use        = $request->input('spl_use');

        $supply_count = (isset($spl_id) && is_array($spl_id)) ? count($spl_id) : array();

        //추가옵션등록
        if($supply_count) {
            // 추가옵션명
            $arr_spl = array();
            for($i=0; $i<$supply_count; $i++) {
                $post_spl_id = strip_tags($spl_id[$i]);

                $spl_val = explode(chr(30), $post_spl_id);
                if(!in_array($spl_val[0], $arr_spl))
                    $arr_spl[] = $spl_val[0];
            }

            $item_supply_subject = implode(',', $arr_spl);

            for($i=0; $i<$supply_count; $i++) {
                //DB 저장 배열 만들기
                $supdata = array(
                    'sio_id'        => $spl_id[$i],
                    'sio_type'      => 1,
                    'item_code'     => $item_code,
                    'sio_price'     => $spl_price[$i],
                    'sio_stock_qty' => $spl_stock_qty[$i],
                    'sio_noti_qty'  => $spl_noti_qty[$i],
                    'sio_use'       => $spl_use[$i],
                );

                //저장 처리
                $supcreate_result = shopitemoptions::create($supdata);
                $supcreate_result->save();
            }
        }

        /***** 본체 상품 처리  ***/
        if($item_rank == "") $item_rank = 0;

        //DB 저장 배열 만들기
        $data = array(
            'sca_id'                => $last_choice_ca_id,
            'item_code'             => $item_code,
            'item_name'             => $item_name,
            'item_basic'            => $item_basic,
            'item_manufacture'      => $item_manufacture,
            'item_origin'           => $item_origin,
            'item_brand'            => $item_brand,
            'item_model'            => $item_model,
            'item_option_subject'   => $item_option_subject,
            'item_supply_subject'   => $item_supply_subject,
            'item_type1'            => $item_type1,
            'item_type2'            => $item_type2,
            'item_type3'            => $item_type3,
            'item_type4'            => $item_type4,
            'item_content'          => $item_content,
            'item_cust_price'       => $item_cust_price,
            'item_price'            => $item_price,
            'item_point_type'       => $item_point_type,
            'item_point'            => $item_point,
            'item_supply_point'     => $item_supply_point,
            'item_use'              => $item_use,
            'item_nocoupon'         => $item_nocoupon,
            'item_soldout'          => $item_soldout,
            'item_stock_qty'        => $item_stock_qty,
            'item_sc_type'          => $item_sc_type,
            'item_sc_method'        => $item_sc_method,
            'item_sc_price'         => $item_sc_price,
            'item_sc_minimum'       => $item_sc_minimum,
            'item_sc_qty'           => $item_sc_qty,
            'item_tel_inq'          => $item_tel_inq,
            'item_display'          => $item_display,
            'item_rank'             => $item_rank,
        );

        //이미지 10개 처리
        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $path = 'data/shopitem';     //첨부물 저장 경로

        for($i = 1; $i <= 10; $i++){
            if($request->hasFile('item_img'.$i))
            {
                $thumb_name = "";
                $item_img[$i] = $request->file('item_img'.$i);
                $file_type = $item_img[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $item_img[$i]->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'item_img'.$i  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                $attachment_result = CustomUtils::attachment_save($item_img[$i],$path); //위의 패스로 이미지 저장됨

                if(!$attachment_result[0])
                {
                    return redirect()->route('shop.item.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                    exit;
                }else{
                    //썸네일 만들기
                    for($k = 0; $k < 3; $k++){
                        $resize_width_file_tmp = explode("%%",$resiz_result['shop_img_width']);
                        $resize_height_file_tmp = explode("%%",$resiz_result['shop_img_height']);

                        $thumb_width = $resize_width_file_tmp[$k];
                        $thumb_height = $resize_height_file_tmp[$k];

                        $is_create = false;
                        $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $data['item_ori_img'.$i] = $attachment_result[2];  //배열에 추가 함
                    $data['item_img'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함
                }
            }
        }

        //저장 처리
        $create_result = shopitems::create($data);
        $create_result->save();

        if($create_result) return redirect(route('shop.item.index'))->with('alert_messages', $Messages::$item['insert']['in_ok']);
        else return redirect(route('shop.item.index'))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function ajax_itemoption(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $opt1_subject   = $request->input('opt1_subject');
        $opt2_subject   = $request->input('opt2_subject');
        $opt3_subject   = $request->input('opt3_subject');

        $opt1_val       = $request->input('opt1');
        $opt2_val       = $request->input('opt2');
        $opt3_val       = $request->input('opt3');

        if(!$opt1_subject || !$opt1_val) {
            echo 'No';
            exit;
        }

        $opt1_count = $opt2_count = $opt3_count = 0;

        if($opt1_val) {
            $opt1 = explode(',', $opt1_val);
            $opt1_count = count($opt1);
        }

        if($opt2_val) {
            $opt2 = explode(',', $opt2_val);
            $opt2_count = count($opt2);
        }

        if($opt3_val) {
            $opt3 = explode(',', $opt3_val);
            $opt3_count = count($opt3);
        }

        $display = '
            <td>
                <table>
                    <tr>
                        <td><input type="checkbox" name="opt_chk_all" value="1" id="opt_chk_all"></td>
                        <td>옵션명</td>
                        <td>추가금액</td>
                        <td>재고수량</td>
                        <td>통보수량</td>
                        <td>사용여부</td>
                    </tr>
        ';

        for($i=0; $i<$opt1_count; $i++) {
            $j = 0;
            do {
                $k = 0;
                do {
                    $opt_1 = isset($opt1[$i]) ? strip_tags(trim($opt1[$i])) : '';
                    $opt_2 = isset($opt2[$j]) ? strip_tags(trim($opt2[$j])) : '';
                    $opt_3 = isset($opt3[$k]) ? strip_tags(trim($opt3[$k])) : '';

                    $opt_2_len = strlen($opt_2);
                    $opt_3_len = strlen($opt_3);

                    $opt_id = $opt_1;
                    if($opt_2_len)
                        $opt_id .= chr(30).$opt_2;
                    if($opt_3_len)
                        $opt_id .= chr(30).$opt_3;
                    $opt_price = 0;
                    $opt_stock_qty = 9999;
                    $opt_noti_qty = 100;
                    $opt_use = 1;

                    $opt_2_exp = "";
                    $opt_3_exp = "";
                    if ($opt_2_len) $opt_2_exp = ' <small>&gt;</small> '.$opt_2;
                    if ($opt_3_len) $opt_3_exp = ' <small>&gt;</small> '.$opt_3;

                    $display .= '
                        <tr>
                            <td class="td_chk">
                                <input type="hidden" name="opt_id[]" value="'.$opt_id.'">
                                <input type="checkbox" name="opt_chk[]" id="opt_chk_'.$i.'" value="1">
                            </td>
                            <td class="opt1-cell" id="opt1-cell">'.$opt_1.$opt_2_exp.$opt_3_exp.'</td>
                            <td class="td_numsmall">
                                <label for="opt_price_'.$i.'" class="sound_only"></label>
                                <input type="text" name="opt_price[]" value="'.$opt_price.'" id="opt_price_'.$i.'" size="9">
                            </td>
                            <td class="td_num">
                                <label for="opt_stock_qty_'.$i.'" class="sound_only"></label>
                                <input type="text" name="opt_stock_qty[]" value="'.$opt_stock_qty.'" id="opt_stock_qty_'.$i.'" size="5">
                            </td>
                            <td class="td_num">
                                <label for="opt_noti_qty_'.$i.'" class="sound_only"></label>
                                <input type="text" name="opt_noti_qty[]" value="'.$opt_noti_qty.'" id="opt_noti_qty_'.$i.'" size="5">
                            </td>
                            <td class="td_mng">
                                <label for="opt_use_'.$i.'" class="sound_only"></label>
                                <select name="opt_use[]" id="opt_use_'.$i.'">
                                    <option value="1">사용함</option>
                                    <option value="0">사용안함</option>
                                </select>
                            </td>
                        </tr>
                    ';

                    $k++;
                } while($k < $opt3_count);

                $j++;
            } while($j < $opt2_count);
        } // for

        $display .= '
                            <tr>
                                <td><input type="button" value="선택삭제" id="sel_option_delete"></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    전체 옵션의 추가금액, 재고/통보수량 및 사용여부를 일괄 적용할 수 있습니다. <br>단, 체크된 수정항목만 일괄 적용됩니다.<br>
                                    추가금액 <input type="checkbox" name="opt_com_price_chk" value="1" id="opt_com_price_chk" class="opt_com_chk">
                                    <input type="text" name="opt_com_price" value="0" id="opt_com_price" class="frm_input" size="5">

                                    재고수량 <input type="checkbox" name="opt_com_stock_chk" value="1" id="opt_com_stock_chk" class="opt_com_chk">
                                    <input type="text" name="opt_com_stock" value="0" id="opt_com_stock" class="frm_input" size="5">

                                    통보수량 <input type="checkbox" name="opt_com_noti_chk" value="1" id="opt_com_noti_chk" class="opt_com_chk">
                                    <input type="text" name="opt_com_noti" value="0" id="opt_com_noti" class="frm_input" size="5">

                                    사용여부 <input type="checkbox" name="opt_com_use_chk" value="1" id="opt_com_use_chk" class="opt_com_chk">
                                    <select name="opt_com_use" id="opt_com_use">
                                        <option value="1">사용함</option>
                                        <option value="0">사용안함</option>
                                    </select>
                                    <button type="button" id="opt_value_apply" class="btn_frmline">일괄적용</button>
                                </td>
                            </tr>
                        </table>
                    </td>
        ';

        echo $display;
    }

    public function ajax_itemsupply(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $subject   = $request->input('subject');
        $supply   = $request->input('supply');

        $subject_count = (isset($subject) && is_array($subject)) ? count($subject) : 0;
        $supply_count = (isset($supply) && is_array($supply)) ? count($supply) : 0;

        if(!$subject_count || !$supply_count) {
            echo 'No';
            exit;
        }

        $display = '
            <td>
                <table>
                    <tr>
                        <td><input type="checkbox" name="spl_chk_all" value="1"></td>
                        <td>옵션명</td>
                        <td>옵션항목</td>
                        <td>상품금액</td>
                        <td>재고수량</td>
                        <td>통보수량</td>
                        <td>사용여부</td>
                    </tr>
        ';

        for($i=0; $i<$subject_count; $i++) {
            $spl_subject = trim(stripslashes($subject[$i]));
            $spl_val = explode(',', trim(stripslashes($supply[$i])));
            $spl_count = count($spl_val);

            for($j=0; $j<$spl_count; $j++) {
                $spl = isset($spl_val[$j]) ? strip_tags(trim($spl_val[$j])) : '';

                if($spl_subject && strlen($spl)) {
                    $spl_id = $spl_subject.chr(30).$spl;
                    $spl_price = 0;
                    $spl_stock_qty = 9999;
                    $spl_noti_qty = 100;
                    $spl_use = 1;

                    $display .= '
                        <tr>
                            <td class="td_chk">
                                <input type="hidden" name="spl_id[]" value="'.$spl_id.'">
                                <input type="checkbox" name="spl_chk[]" id="spl_chk_'.$i.'" value="1">
                            </td>
                            <td class="spl-subject-cell">'.$spl_subject.'</td>
                            <td class="spl-cell">'.$spl.'</td>
                            <td class="td_numsmall">
                                <input type="text" name="spl_price[]" value="'.$spl_price.'" id="spl_price_'.$i.'" size="9">
                            </td>
                            <td class="td_num">
                                <input type="text" name="spl_stock_qty[]" value="'.$spl_stock_qty.'" id="spl_stock_qty_'.$i.'" size="5">
                            </td>
                            <td class="td_num">
                                <input type="text" name="spl_noti_qty[]" value="'.$spl_noti_qty.'" id="spl_noti_qty_'.$i.'" size="5">
                            </td>
                            <td class="td_mng">
                                <select name="spl_use[]" id="spl_use_'.$i.'">
                                    <option value="1" >사용함</option>
                                    <option value="0" >사용안함</option>
                                </select>
                            </td>
                        </tr>
                    ';
                }
            }
        }

        $display .= '
                        <tr>
                            <td><button type="button" id="sel_supply_delete">선택삭제</button></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                            전체 추가 옵션의 상품금액, 재고/통보수량 및 사용여부를 일괄 적용할 수 있습니다.  <br>단, 체크된 수정항목만 일괄 적용됩니다.<br>
                                상품금액 <input type="checkbox" name="spl_com_price_chk" value="1" id="spl_com_price_chk" class="spl_com_chk">
                                <input type="text" name="spl_com_price" value="0" id="spl_com_price" class="frm_input" size="9">

                                재고수량 <input type="checkbox" name="spl_com_stock_chk" value="1" id="spl_com_stock_chk" class="spl_com_chk">
                                <input type="text" name="spl_com_stock" value="0" id="spl_com_stock" class="frm_input" size="5">

                                통보수량 <input type="checkbox" name="spl_com_noti_chk" value="1" id="spl_com_noti_chk" class="spl_com_chk">
                                <input type="text" name="spl_com_noti" value="0" id="spl_com_noti" class="frm_input" size="5">

                                사용여부 <input type="checkbox" name="spl_com_use_chk" value="1" id="spl_com_use_chk" class="spl_com_chk">
                                <select name="spl_com_use" id="spl_com_use">
                                    <option value="1">사용함</option>
                                    <option value="0">사용안함</option>
                                </select>
                                <button type="button" id="spl_value_apply" class="btn_frmline">일괄적용</button>
                            </td>
                        </tr>
                    </table>
                </td>
        ';

        echo $display;
    }

    public function choice_del(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $path = 'data/shopitem';     //첨부물 저장 경로
        $editor_path = $path."/editor";     //스마트 에디터 첨부 저장 경로

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            //먼저 상품을 검사하여 파일이 있는지 파악 하고 같이 삭제 함
            $item_info = DB::table('shopitems')->where('id', $request->input('chk_id')[$i])->first();

            //스마트 에디터 내용에 첨부된 이미지 색제
            $editor_img_del = CustomUtils::editor_img_del($item_info->item_content, $editor_path);

            for($m = 1; $m <= 10; $m++){
                $item_img_file = 'item_img'.$m;
                if($item_info->$item_img_file != ""){
                    $file_cnt = explode('@@',$item_info->$item_img_file);

                    for($j = 0; $j < count($file_cnt); $j++){
                        $img_path = "";
                        $img_path = $path.'/'.$file_cnt[$j];
                        if (file_exists($img_path)) {
                            @unlink($img_path); //이미지 삭제
                        }
                    }
                }
            }

            DB::table('shopitemoptions')->where('item_code',$item_info->item_code)->delete();   //옵션 row 삭제
            DB::table('shopitems')->where('id',$request->input('chk_id')[$i])->delete();   //row 삭제
        }

        return redirect()->route('shop.item.index')->with('alert_messages', $Messages::$item['del']['del_ok']);
    }

    public function modify(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id     = $request->input('id');
        $ca_id  = $request->input('sca_id');

        if($id == "" && $ca_id == ""){
            return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
            exit;
        }

        //환경 설정 DB에서 이미지 리사이징 값이 있는 지 파악
        $resiz_result = CustomUtils::resize_chk();

        if(!$resiz_result){
            return redirect(route('shop.setting.index'))->with('alert_messages', $Messages::$shop['no_resize']);  //치명적인 에러가 있을시
            exit;
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $item_directory = "data/shopitem/editor";
        setcookie('directory', $item_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $item_info = DB::table('shopitems')->where([['id',$id],['sca_id',$ca_id]])->first();


        //1단계 가져옴
        $one_str_cut = substr($item_info->sca_id,0,2);
        $one_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_id', 'ASC')->get();


        //2단계 가져옴
        $two_str_cut = substr($item_info->sca_id,0,4);
        $two_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where([['sca_display','Y'],['sca_id','like',$one_str_cut.'%']])->whereRaw('length(sca_id) = 4')->orderby('sca_id', 'ASC')->get();

        //3단계 가져옴
        $three_str_cut = substr($item_info->sca_id,0,6);
        $three_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where([['sca_display','Y'],['sca_id','like',$two_str_cut.'%']])->whereRaw('length(sca_id) = 6')->orderby('sca_id', 'ASC')->get();

        //4단계 가져옴
        $four_str_cut = substr($item_info->sca_id,0,8);
        $four_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where([['sca_display','Y'],['sca_id','like',$three_str_cut.'%']])->whereRaw('length(sca_id) = 8')->orderby('sca_id', 'ASC')->get();

        //5단계 가져옴
        $five_str_cut = substr($item_info->sca_id,0,10);
        $five_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where([['sca_display','Y'],['sca_id','like',$four_str_cut.'%']])->whereRaw('length(sca_id) = 10')->orderby('sca_id', 'ASC')->get();

        return view('adm.shop.item.itemmodify',[
            'one_step_infos'    => $one_step_infos,
            'two_step_infos'    => $two_step_infos,
            'three_step_infos'  => $three_step_infos,
            'four_step_infos'   => $four_step_infos,
            'five_step_infos'   => $five_step_infos,
            'item_info'         => $item_info,
            'ca_id'             => $ca_id,
            'one_str_cut'       => $one_str_cut,
            'two_str_cut'       => $two_str_cut,
            'three_str_cut'     => $three_str_cut,
            'four_str_cut'      => $four_str_cut,
            'five_str_cut'      => $five_str_cut,
        ]);
    }

    public function ajax_modi_itemoption(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code      = $request->input('item_code');
        $opt1_subject   = $request->input('opt1_subject');
        $opt2_subject   = $request->input('opt2_subject');
        $opt3_subject   = $request->input('opt3_subject');

        $itemoption_infos = DB::table('shopitemoptions')->where([['item_code', $item_code],['sio_type','0']])->orderby('id', 'asc')->get();

        $display = '
            <td>
                <table>
                    <tr>
                        <td><input type="checkbox" name="opt_chk_all" value="1" id="opt_chk_all"></td>
                        <td>옵션명</td>
                        <td>추가금액</td>
                        <td>재고수량</td>
                        <td>통보수량</td>
                        <td>사용여부</td>
                    </tr>
        ';

        $i = 0;
        foreach($itemoption_infos as $itemoption_info){
            $opt_id = $itemoption_info->sio_id;
            $opt_val = explode(chr(30), $opt_id);
            $opt_1 = $opt_val[0];
            $opt_2 = isset($opt_val[1]) ? $opt_val[1] : '';
            $opt_3 = isset($opt_val[2]) ? $opt_val[2] : '';
            $opt_2_len = strlen($opt_2);
            $opt_3_len = strlen($opt_3);
            $opt_price = $itemoption_info->sio_price;
            $opt_stock_qty = $itemoption_info->sio_stock_qty;
            $opt_noti_qty = $itemoption_info->sio_noti_qty;

            $opt_use = $itemoption_info->sio_use;
            if($opt_use == 1){
                $opt_use1 = "selected";
                $opt_use0 = "";
            }else{
                $opt_use1 = "";
                $opt_use0 = "selected";
            }

            $opt_2_exp = "";
            $opt_3_exp = "";
            if ($opt_2_len) $opt_2_exp = ' <small>&gt;</small> '.$opt_2;
            if ($opt_3_len) $opt_3_exp = ' <small>&gt;</small> '.$opt_3;

            $display .= '
                <tr>
                    <td class="td_chk">
                        <input type="hidden" name="opt_id[]" value="'.$opt_id.'">
                        <input type="checkbox" name="opt_chk[]" id="opt_chk_'.$i.'" value="1">
                    </td>
                    <td class="opt-cell">'.$opt_1.$opt_2_exp.$opt_3_exp.'</td>
                    <td class="td_numsmall">
                        <label for="opt_price_'.$i.'" class="sound_only"></label>
                        <input type="text" name="opt_price[]" value="'.$opt_price.'" id="opt_price_'.$i.'" size="9">
                    </td>
                    <td class="td_num">
                        <label for="opt_stock_qty_'.$i.'" class="sound_only"></label>
                        <input type="text" name="opt_stock_qty[]" value="'.$opt_stock_qty.'" id="opt_stock_qty_'.$i.'" size="5">
                    </td>
                    <td class="td_num">
                        <label for="opt_noti_qty_'.$i.'" class="sound_only"></label>
                        <input type="text" name="opt_noti_qty[]" value="'.$opt_noti_qty.'" id="opt_noti_qty_'.$i.'" size="5">
                    </td>
                    <td class="td_mng">
                        <label for="opt_use_'.$i.'" class="sound_only"></label>
                        <select name="opt_use[]" id="opt_use_'.$i.'">
                            <option value="1" '.$opt_use1.'>사용함</option>
                            <option value="0" '.$opt_use0.'>사용안함</option>
                        </select>
                    </td>
                </tr>
            ';

            $i++;
        }

        $display .= '
                <tr>
                    <td><input type="button" value="선택삭제" id="sel_option_delete"></td>
                </tr>
                <tr>
                    <td colspan="5">
                        전체 옵션의 추가금액, 재고/통보수량 및 사용여부를 일괄 적용할 수 있습니다. <br>단, 체크된 수정항목만 일괄 적용됩니다.<br>
                        추가금액 <input type="checkbox" name="opt_com_price_chk" value="1" id="opt_com_price_chk" class="opt_com_chk">
                        <input type="text" name="opt_com_price" value="0" id="opt_com_price" class="frm_input" size="5">

                        재고수량 <input type="checkbox" name="opt_com_stock_chk" value="1" id="opt_com_stock_chk" class="opt_com_chk">
                        <input type="text" name="opt_com_stock" value="0" id="opt_com_stock" class="frm_input" size="5">

                        통보수량 <input type="checkbox" name="opt_com_noti_chk" value="1" id="opt_com_noti_chk" class="opt_com_chk">
                        <input type="text" name="opt_com_noti" value="0" id="opt_com_noti" class="frm_input" size="5">

                        사용여부 <input type="checkbox" name="opt_com_use_chk" value="1" id="opt_com_use_chk" class="opt_com_chk">
                        <select name="opt_com_use" id="opt_com_use">
                            <option value="1">사용함</option>
                            <option value="0">사용안함</option>
                        </select>
                        <button type="button" id="opt_value_apply" class="btn_frmline">일괄적용</button>
                    </td>
                </tr>
            </table>
        </td>
        ';

        echo $display;
    }

    public function ajax_modi_itemsupply(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code      = $request->input('item_code');

        $itemoption_infos = DB::table('shopitemoptions')->where([['item_code', $item_code],['sio_type','1']])->orderby('id', 'asc')->get();

        $display = '
            <td>
                <table>
                    <tr>
                        <td><input type="checkbox" name="spl_chk_all" value="1"></td>
                        <td>옵션명</td>
                        <td>옵션항목</td>
                        <td>상품금액</td>
                        <td>재고수량</td>
                        <td>통보수량</td>
                        <td>사용여부</td>
                    </tr>
        ';

        $i = 0;
        foreach($itemoption_infos as $itemoption_info){
            $spl_id = $itemoption_info->sio_id;
            $spl_val = explode(chr(30), $spl_id);
            $spl_subject = $spl_val[0];
            $spl = $spl_val[1];
            $spl_price = $itemoption_info->sio_price;
            $spl_stock_qty = $itemoption_info->sio_stock_qty;
            $spl_noti_qty = $itemoption_info->sio_noti_qty;

            $spl_use = $itemoption_info->sio_use;
            if($spl_use == 1){
                $spl_use1 = "selected";
                $spl_use0 = "";
            }else{
                $spl_use1 = "";
                $spl_use0 = "selected";
            }

            $display .= '
                    <tr>
                        <td class="td_chk">
                            <input type="hidden" name="spl_id[]" value="'.$spl_id.'">
                            <input type="checkbox" name="spl_chk[]" id="spl_chk_'.$i.'" value="1">
                        </td>
                        <td class="spl-subject-cell">'.$spl_subject.'</td>
                        <td class="spl-cell">'.$spl.'</td>
                        <td class="td_numsmall">
                            <input type="text" name="spl_price[]" value="'.$spl_price.'" id="spl_price_'.$i.'" size="9">
                        </td>
                        <td class="td_num">
                            <input type="text" name="spl_stock_qty[]" value="'.$spl_stock_qty.'" id="spl_stock_qty_'.$i.'" size="5">
                        </td>
                        <td class="td_num">
                            <input type="text" name="spl_noti_qty[]" value="'.$spl_noti_qty.'" id="spl_noti_qty_'.$i.'" size="5">
                        </td>
                        <td class="td_mng">
                            <select name="spl_use[]" id="spl_use_'.$i.'">
                                <option value="1" '.$spl_use1.'>사용함</option>
                                <option value="0" '.$spl_use0.'>사용안함</option>
                            </select>
                        </td>
                    </tr>
            ';

            $i++;
        }

        $display .= '
                    <tr>
                        <td><button type="button" id="sel_supply_delete">선택삭제</button></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                        전체 추가 옵션의 상품금액, 재고/통보수량 및 사용여부를 일괄 적용할 수 있습니다.  <br>단, 체크된 수정항목만 일괄 적용됩니다.<br>
                            상품금액 <input type="checkbox" name="spl_com_price_chk" value="1" id="spl_com_price_chk" class="spl_com_chk">
                            <input type="text" name="spl_com_price" value="0" id="spl_com_price" class="frm_input" size="9">

                            재고수량 <input type="checkbox" name="spl_com_stock_chk" value="1" id="spl_com_stock_chk" class="spl_com_chk">
                            <input type="text" name="spl_com_stock" value="0" id="spl_com_stock" class="frm_input" size="5">

                            통보수량 <input type="checkbox" name="spl_com_noti_chk" value="1" id="spl_com_noti_chk" class="spl_com_chk">
                            <input type="text" name="spl_com_noti" value="0" id="spl_com_noti" class="frm_input" size="5">

                            사용여부 <input type="checkbox" name="spl_com_use_chk" value="1" id="spl_com_use_chk" class="spl_com_chk">
                            <select name="spl_com_use" id="spl_com_use">
                                <option value="1">사용함</option>
                                <option value="0">사용안함</option>
                            </select>
                            <button type="button" id="spl_value_apply" class="btn_frmline">일괄적용</button>
                        </td>
                    </tr>
                </table>
            </td>
        ';

        echo $display;
    }

    public function modifysave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        if(!isset($_COOKIE['directory'])){  //쿠키 값이 사라진 후에 저장 되지 않게
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }

        //환경 설정 DB에서 이미지 리사이징 값이 있는 지 파악
        $resiz_result = CustomUtils::resize_chk();

        if(!$resiz_result){
            return redirect(route('shop.setting.index'))->with('alert_messages', $Messages::$shop['no_resize']);  //치명적인 에러가 있을시
            exit;
        }

        $id                     = $request->input('id');
        $ca_id                  = $request->input('ca_id');
        $item_code              = $request->input('item_code');
        $item_name              = addslashes($request->input('item_name'));
        $item_basic             = $request->input('item_basic');
        $item_manufacture       = $request->input('item_manufacture');
        $item_origin            = $request->input('item_origin');
        $item_brand             = $request->input('item_brand');
        $item_model             = $request->input('item_model');
        $item_option_subject    = $request->input('item_option_subject');
        $item_supply_subject    = $request->input('item_supply_subject');
        $item_type1             = (int)$request->input('item_type1');
        $item_type2             = (int)$request->input('item_type2');
        $item_type3             = (int)$request->input('item_type3');
        $item_type4             = (int)$request->input('item_type4');
        $item_content           = $request->input('item_content');
        $item_cust_price        = (int)$request->input('item_cust_price');
        $item_price             = (int)$request->input('item_price');
        $item_point_type        = (int)$request->input('item_point_type');
        $item_point             = (int)$request->input('item_point');
        $item_supply_point      = (int)$request->input('item_supply_point');
        $item_use               = (int)$request->input('item_use');
        $item_nocoupon          = (int)$request->input('item_nocoupon');
        $item_soldout           = (int)$request->input('item_soldout');
        $item_stock_qty         = $request->input('item_stock_qty');
        $item_sc_type           = $request->input('item_sc_type');
        $item_sc_method         = $request->input('item_sc_method');
        $item_sc_price          = $request->input('item_sc_price');
        $item_sc_minimum        = $request->input('item_sc_minimum');
        $item_sc_qty            = $request->input('item_sc_qty');
        $item_tel_inq           = (int)$request->input('item_tel_inq');
        $item_display           = $request->input('item_display');
        $item_rank              = (int)$request->input('item_rank');
        $length                 = (int)$request->input('length');
        $last_choice_ca_id      = $request->input('last_choice_ca_id');

        if(is_null($id) || is_null($ca_id) || is_null($item_code) || is_null($item_name)){
            return redirect(route('shop.item.index'))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $item_info = DB::table('shopitems')->where([['id', $id], ['item_code',$item_code]])->first();   //기존 상품정보 읽기

        /***** 옵션 처리  ***/
        //상품 선택 옵션 처리
        $del_option_result = DB::table('shopitemoptions')->where([['item_code',$item_code],["sio_type","0"]])->delete();   //기존 상품 옵션 삭제

        $opt_id         = $request->input('opt_id');
        $opt_price      = $request->input('opt_price');
        $opt_stock_qty  = $request->input('opt_stock_qty');
        $opt_noti_qty   = $request->input('opt_noti_qty');
        $opt_use        = $request->input('opt_use');
        $opt1_subject   = $request->input('opt1_subject');
        $opt2_subject   = $request->input('opt2_subject');
        $opt3_subject   = $request->input('opt3_subject');

        $option_count = (isset($opt_id) && is_array($opt_id)) ? count($opt_id) : array();

        //선택옵션등록
        if($option_count) {
            // 옵션명
            $opt1_cnt = $opt2_cnt = $opt3_cnt = 0;
            for($i=0; $i<$option_count; $i++) {
                $post_opt_id = strip_tags($opt_id[$i]);

                $opt_val = explode(chr(30), $post_opt_id);
                if(isset($opt_val[0]) && $opt_val[0])
                    $opt1_cnt++;
                if(isset($opt_val[1]) && $opt_val[1])
                    $opt2_cnt++;
                if(isset($opt_val[2]) && $opt_val[2])
                    $opt3_cnt++;
            }

            if($opt1_subject && $opt1_cnt) {
                $item_option_subject = $opt1_subject;
                if($opt2_subject && $opt2_cnt)
                    $item_option_subject .= ','.$opt2_subject;
                if($opt3_subject && $opt3_cnt)
                    $item_option_subject .= ','.$opt3_subject;
            }

            for($i=0; $i<$option_count; $i++) {
                //DB 저장 배열 만들기
                $optdata = array(
                    'sio_id'        => $opt_id[$i],
                    'sio_type'      => 0,
                    'item_code'     => $item_code,
                    'sio_price'     => $opt_price[$i],
                    'sio_stock_qty' => $opt_stock_qty[$i],
                    'sio_noti_qty'  => $opt_noti_qty[$i],
                    'sio_use'       => $opt_use[$i],
                );

                //저장 처리
                $optcreate_result = shopitemoptions::create($optdata);
                $optcreate_result->save();
            }
        }

        //상품 추가 옵션 처리
        $del_supply_result = DB::table('shopitemoptions')->where([['item_code',$item_code],["sio_type","1"]])->delete();   //기존 상품 추가 옵션 삭제

        $spl_id         = $request->input('spl_id');
        $spl_price      = $request->input('spl_price');
        $spl_stock_qty  = $request->input('spl_stock_qty');
        $spl_noti_qty   = $request->input('spl_noti_qty');
        $spl_use        = $request->input('spl_use');

        $supply_count = (isset($spl_id) && is_array($spl_id)) ? count($spl_id) : array();

        //추가옵션등록
        if($supply_count) {
            // 추가옵션명
            $arr_spl = array();
            for($i=0; $i<$supply_count; $i++) {
                $post_spl_id = strip_tags($spl_id[$i]);

                $spl_val = explode(chr(30), $post_spl_id);
                if(!in_array($spl_val[0], $arr_spl))
                    $arr_spl[] = $spl_val[0];
            }

            $item_supply_subject = implode(',', $arr_spl);

            for($i=0; $i<$supply_count; $i++) {
                //DB 저장 배열 만들기
                $supdata = array(
                    'sio_id'        => $spl_id[$i],
                    'sio_type'      => 1,
                    'item_code'     => $item_code,
                    'sio_price'     => $spl_price[$i],
                    'sio_stock_qty' => $spl_stock_qty[$i],
                    'sio_noti_qty'  => $spl_noti_qty[$i],
                    'sio_use'       => $spl_use[$i],
                );

                //저장 처리
                $supcreate_result = shopitemoptions::create($supdata);
                $supcreate_result->save();
            }
        }

        /***** 본체 상품 처리  ***/
        if($item_rank == "") $item_rank = 0;

        //DB 저장 배열 만들기
        $data = array(
            'sca_id'                => $last_choice_ca_id,
            'item_code'             => $item_code,
            'item_name'             => $item_name,
            'item_basic'            => $item_basic,
            'item_manufacture'      => $item_manufacture,
            'item_origin'           => $item_origin,
            'item_brand'            => $item_brand,
            'item_model'            => $item_model,
            'item_option_subject'   => $item_option_subject,
            'item_supply_subject'   => $item_supply_subject,
            'item_type1'            => $item_type1,
            'item_type2'            => $item_type2,
            'item_type3'            => $item_type3,
            'item_type4'            => $item_type4,
            'item_content'          => $item_content,
            'item_cust_price'       => $item_cust_price,
            'item_price'            => $item_price,
            'item_point_type'       => $item_point_type,
            'item_point'            => $item_point,
            'item_supply_point'     => $item_supply_point,
            'item_use'              => $item_use,
            'item_nocoupon'         => $item_nocoupon,
            'item_soldout'          => $item_soldout,
            'item_stock_qty'        => $item_stock_qty,
            'item_sc_type'          => $item_sc_type,
            'item_sc_method'        => $item_sc_method,
            'item_sc_price'         => $item_sc_price,
            'item_sc_minimum'       => $item_sc_minimum,
            'item_sc_qty'           => $item_sc_qty,
            'item_tel_inq'          => $item_tel_inq,
            'item_display'          => $item_display,
            'item_rank'             => $item_rank,
        );

        /*** 이미지 처리 */
        //이미지 10개 처리
        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $path = 'data/shopitem';     //첨부물 저장 경로

        for($i = 1; $i <= 10; $i++){
            $thumb_name = "";
            $file_chk_tmp = 'file_chk'.$i;
            $file_chk = $request->input($file_chk_tmp); //수정,삭제,새로등록 체크 파악

            if($file_chk == 1){ //체크된 것들만 액션
                if($request->hasFile('item_img'.$i))    //첨부가 있음
                {
                    $item_img[$i] = $request->file('item_img'.$i);
                    $file_type = $item_img[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                    $file_size = $item_img[$i]->getSize();  //첨부 파일 사이즈 구함

                    //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                    $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                    //첨부 파일 용량 예외처리
                    Validator::validate($request->all(), [
                        'item_img'.$i  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                    ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                    $attachment_result = CustomUtils::attachment_save($item_img[$i],$path); //위의 패스로 이미지 저장됨

                    if(!$attachment_result[0])
                    {
                        return redirect()->route('shop.item.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                        exit;
                    }else{
                        //썸네일 만들기
                        for($k = 0; $k < 3; $k++){
                            $resize_width_file_tmp = explode("%%",$resiz_result['shop_img_width']);
                            $resize_height_file_tmp = explode("%%",$resiz_result['shop_img_height']);

                            $thumb_width = $resize_width_file_tmp[$k];
                            $thumb_height = $resize_height_file_tmp[$k];

                            $is_create = false;
                            $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                        }

                        $data['item_ori_img'.$i] = $attachment_result[2];  //배열에 추가 함
                        $data['item_img'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                        //기존 첨부 파일 삭제
                        $item_img_tmp = 'item_img'.$i;

                        if($item_info->$item_img_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                            $file_cnt1 = explode('@@',$item_info->$item_img_tmp);
                            for($j = 0; $j < count($file_cnt1); $j++){
                                $img_path = "";
                                $img_path = $path.'/'.$file_cnt1[$j];
                                if (file_exists($img_path)) {
                                    @unlink($img_path); //이미지 삭제
                                }
                            }
                        }
                    }
                }else{
                    //체크는 되었으나 첨부파일이 없을때 기존 첨부 파일 삭제
                    //기존 첨부 파일 삭제
                    $item_img_tmp = 'item_img'.$i;

                    if($item_info->$item_img_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                        $file_cnt1 = explode('@@',$item_info->$item_img_tmp);
                        for($j = 0; $j < count($file_cnt1); $j++){
                            $img_path = "";
                            $img_path = $path.'/'.$file_cnt1[$j];
                            if (file_exists($img_path)) {
                                @unlink($img_path); //이미지 삭제
                            }
                        }
                    }

                    $data['item_ori_img'.$i] = "";  //배열에 추가 함
                    $data['item_img'.$i] = "";  //배열에 추가 함
                }
            }
        }

        //$update_result = DB::table('shopitems')->where([['id', $id], ['item_code',$item_code]])->update($data);
        $update_result = Shopitems::find($id)->update($data);

        if($update_result) return redirect(route('shop.item.index'))->with('alert_messages', $Messages::$item['update']['up_ok']);
        else return redirect(route('shop.item.index'))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function downloadfile(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id         = $request->input('id');
        $ca_id      = $request->input('ca_id');
        $file_num   = $request->input('file_num');

        $item_ori_file = "item_ori_img$file_num";
        $item_img = "item_img$file_num";

        $item_info = DB::table('shopitems')->select($item_ori_file, $item_img)->where([['id', $id], ['sca_id',$ca_id]])->first();    //게시물 정보 추출

        $file_cut = explode("@@",$item_info->$item_img);
        $path = 'data/shopitem';     //첨부물 저장 경로

        $down_file = public_path($path.'/'.$file_cut[0]);

        return response()->download($down_file, $item_info->$item_ori_file);
    }
}
