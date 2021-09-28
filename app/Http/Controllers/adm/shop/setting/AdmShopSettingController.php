<?php
#############################################################################
#
#		파일이름		:		AdmShopSettingController.php
#		파일설명		:		관리자 쇼핑몰 환경 설정 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 27일
#		최종수정일		:		2021년 09월 27일
#
###########################################################################-->

namespace App\Http\Controllers\adm\shop\setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\shopsettings;    //환경 설정 모델 정의

class AdmShopSettingController extends Controller
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

    public function index()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $setting_info = DB::table('shopsettings')->first();

        $id = "";
        $company_name           = "회사명";
        $company_saupja_no      = "123-45-67890";
        $company_owner          = "대표자명";
        $company_tel            = "02-123-4567";
        $company_fax            = "02-123-4568";
        $company_tongsin_no     = "제 OO구 - 123호";
        $company_buga_no        = "12345호";
        $company_zip            = "123456";
        $company_addr           = "OO도 OO시 OO구 OO동 123-45";
        $company_info_name      = "정보책임자명";
        $company_info_email     = "정보책임자 E-mail";
        $company_bank_use       = "";
        $company_bank_account   = "OO은행 12345-67-89012 예금주명";
        $company_use_point      = "";
        $shop_img_width         = "500%%300%%100";
        $shop_img_height        = "500%%300%%100";

        if(!is_null($setting_info)){
            $id = $setting_info->id;

            $company_name           = $setting_info->company_name;
            $company_saupja_no      = $setting_info->company_saupja_no;
            $company_owner          = $setting_info->company_owner;
            $company_tel            = $setting_info->company_tel;
            $company_fax            = $setting_info->company_fax;
            $company_tongsin_no     = $setting_info->company_tongsin_no;
            $company_buga_no        = $setting_info->company_buga_no;
            $company_zip            = $setting_info->company_zip;
            $company_addr           = $setting_info->company_addr;
            $company_info_name      = $setting_info->company_info_name;
            $company_info_email     = $setting_info->company_info_email;
            $company_bank_use       = $setting_info->company_bank_use;
            $company_bank_account   = $setting_info->company_bank_account;
            $company_use_point      = $setting_info->company_use_point;
            $shop_img_width         = $setting_info->shop_img_width;
            $shop_img_height        = $setting_info->shop_img_height;
        }

        return view('adm.shop.setting.setting',[
            'id'                    => $id,
            'company_name'          => $company_name,
            'company_saupja_no'     => $company_saupja_no,
            'company_owner'         => $company_owner,
            'company_tel'           => $company_tel,
            'company_fax'           => $company_fax,
            'company_tongsin_no'    => $company_tongsin_no,
            'company_buga_no'       => $company_buga_no,
            'company_zip'           => $company_zip,
            'company_addr'          => $company_addr,
            'company_info_name'     => $company_info_name,
            'company_info_email'    => $company_info_email,
            'company_bank_use'      => $company_bank_use,
            'company_bank_account'  => $company_bank_account,
            'company_use_point'     => $company_use_point,
            'shop_img_width'        => $shop_img_width,
            'shop_img_height'       => $shop_img_height,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function savesetting(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id                     = $request->input('id');
        $company_name           = $request->input('company_name');
        $company_saupja_no      = $request->input('company_saupja_no');
        $company_owner          = $request->input('company_owner');
        $company_tel            = $request->input('company_tel');
        $company_fax            = $request->input('company_fax');
        $company_tongsin_no     = $request->input('company_tongsin_no');
        $company_buga_no        = $request->input('company_buga_no');
        $company_zip            = $request->input('company_zip');
        $company_addr           = $request->input('company_addr');
        $company_info_name      = $request->input('company_info_name');
        $company_info_email     = $request->input('company_info_email');
        $company_bank_use       = $request->input('company_bank_use');
        $company_bank_account   = $request->input('company_bank_account');
        $company_use_point      = $request->input('company_use_point');
        $shop_img_width         = $request->input('shop_img_width');
        $shop_img_height        = $request->input('shop_img_height');

        $shop_img_width_tmp     = explode("%%",$shop_img_width);
        $shop_img_height_tmp    = explode("%%",$shop_img_height);

        if($shop_img_width_tmp[2] == ""){   //3개가 등록 되었는지 체크
            return redirect(route('shop.setting.index'))->with('alert_messages', $Messages::$shop['resize_num']);  //리사이즈 갯수 체크
            exit;
        }

        if($shop_img_height_tmp[2] == ""){  //3개가 등록 되었는지 체크
            return redirect(route('shop.setting.index'))->with('alert_messages', $Messages::$shop['resize_num']);  //리사이즈 갯수 체크
            exit;
        }

        $data = array(
            'company_name'          => $company_name,
            'company_saupja_no'     => $company_saupja_no,
            'company_owner'         => $company_owner,
            'company_tel'           => $company_tel,
            'company_fax'           => $company_fax,
            'company_tongsin_no'    => $company_tongsin_no,
            'company_buga_no'       => $company_buga_no,
            'company_zip'           => $company_zip,
            'company_addr'          => $company_addr,
            'company_info_name'     => $company_info_name,
            'company_info_email'    => $company_info_email,
            'company_bank_use'      => (int)$company_bank_use,
            'company_bank_account'  => $company_bank_account,
            'company_use_point'     => (int)$company_use_point,
            'shop_img_width'        => $shop_img_width,
            'shop_img_height'       => $shop_img_height,
        );

        if(is_null($id)){
            //등록
            $create_result = shopsettings::create($data);
            $create_result->save();
        }else{
            //수정
            $update_result = shopsettings::find($id)->update($data);
        }

        return redirect(route('shop.setting.index'))->with('alert_messages', $Messages::$shop['in_ok']);
    }
}
