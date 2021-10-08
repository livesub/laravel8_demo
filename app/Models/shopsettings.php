<?php
#############################################################################
#
#		파일이름		:		shopsettings.php
#		파일설명		:		쇼핑몰 환경 설정 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 20일
#		최종수정일		:		2021년 09월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopsettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_saupja_no',
        'company_owner',
        'company_tel',
        'company_fax',
        'company_tongsin_no',
        'company_buga_no',
        'company_zip',
        'company_addr',
        'company_info_name',
        'company_info_email',
        'company_bank_use',
        'company_bank_account',
        'company_use_point',
        'member_reg_coupon_use',
        'member_reg_coupon_price',
        'member_reg_coupon_minimum',
        'member_reg_coupon_term',
        'shop_img_width',
        'shop_img_height',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}
