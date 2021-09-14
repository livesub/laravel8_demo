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
        $writeList   = 10;  //페이지당 글수
        $pageNumList = 10; //블럭당 페이지수

        $tb_name = "shopitems";
        $type = 'shopitems';
        $cate = "";

        //검색 selectbox 만들기
        $search_selectboxs = DB::table('shopcategorys')->orderby('sca_rank','DESC')->orderby('sca_id','ASC')->get();

        //검색 처리
        $cate_search    = $request->input('cate_search');
        $item_search    = $request->input('item_search');
        $keyword        = $request->input('keyword');

        if($item_search == "") $item_search = "item_name";
        $search_sql = "";

        if($cate_search != ""){
            $search_sql = " AND a.sca_id = b.sca_id AND a.sca_id LIKE '{$cate_search}%' AND a.{$item_search} LIKE '%{$keyword}%' ";
        }else{
            $search_sql .= " AND a.sca_id = b.sca_id AND a.{$item_search} LIKE '%{$keyword}%' ";
        }

        $page_control = CustomUtils::page_function('shopitems',$pageNum,$writeList,$pageNumList,$type,$tb_name,$cate_search,$item_search,$keyword);

        $item_infos = DB::select("select a.*, b.sca_id from shopitems a, shopcategorys b where 1 {$search_sql} order by a.id DESC, a.item_rank ASC limit {$page_control['startNum']}, {$writeList} ");

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        return view('adm.shop.item.itemlist',[
            'item_infos'        => $item_infos,
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
            'cate_search'       => $cate_search,
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

        $ca_id              = $request->input('ca_id');
        $length             = $request->input('length');
        $last_choice_ca_id  = $request->input('last_choice_ca_id');
        $item_code          = $request->input('item_code');
        $item_name          = addslashes($request->input('item_name'));
        $item_display       = $request->input('item_display');
        $item_rank          = $request->input('item_rank');
        $item_content       = $request->input('item_content');

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $thumb_name = "";
        if($item_rank == "") $item_rank = 0;

        //DB 저장 배열 만들기
        $data = array(
            'sca_id'         => $last_choice_ca_id,
            'item_code'     => $item_code,
            'item_name'     => $item_name,
            'item_display'  => $item_display,
            'item_rank'     => $item_rank,
            'item_content'  => $item_content,
        );

        if($request->hasFile('item_img'))
        {
            $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

            $item_img = $request->file('item_img');
            $file_type = $item_img->getClientOriginalExtension();    //이미지 확장자 구함
            $file_size = $item_img->getSize();  //첨부 파일 사이즈 구함

            //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
            $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

            //첨부 파일 용량 예외처리
            Validator::validate($request->all(), [
                'item_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
            ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

            $path = 'data/shopitem';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($item_img,$path); //위의 패스로 이미지 저장됨

            if(!$attachment_result[0])
            {
                return redirect()->route('shop.item.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                exit;
            }else{
                for($k = 0; $k < 3; $k++){
                    $resize_width_file_tmp = explode("%%","500%%300%%100");
                    $resize_height_file_tmp = explode("%%","500%%300%%100");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                $data['sitem_ori_img'] = $attachment_result[2];  //배열에 추가 함
                $data['sitem_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
            }
        }

        //저장 처리
        $create_result = shopitems::create($data);
        $create_result->save();

        if($create_result = 1) return redirect(route('shop.item.index'))->with('alert_messages', $Messages::$item['insert']['in_ok']);
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
                            <td class="opt1-cell">'.$opt_1.$opt_2_exp.$opt_3_exp.'</td>
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
