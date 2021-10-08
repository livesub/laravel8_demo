<?php
#############################################################################
#
#		파일이름		:		shopitems.php
#		파일설명		:		쇼핑몰 상품 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 20일
#		최종수정일		:		2021년 09월 20일
#
###########################################################################-->


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class shopitems extends Model
{
    use HasFactory, Notifiable;
    //use HasFactory;

    protected $fillable = [
        'sca_id',
        'item_code',
        'item_name',
        'item_basic',
        'item_manufacture',
        'item_origin',
        'item_brand',
        'item_model',
        'item_option_subject',
        'item_supply_subject',
        'item_content',
        'item_sc_type',
        'item_sc_method',
        'item_sc_price',
        'item_sc_minimum',
        'item_sc_qty',
        'item_display',
        'item_rank',
        'item_img1',
        'item_ori_img1',
        'item_img2',
        'item_ori_img2',
        'item_img3',
        'item_ori_img3',
        'item_img4',
        'item_ori_img4',
        'item_img5',
        'item_ori_img5',
        'item_img6',
        'item_ori_img6',
        'item_img7',
        'item_ori_img7',
        'item_img8',
        'item_ori_img8',
        'item_img9',
        'item_ori_img9',
        'item_img10',
        'item_ori_img10',
        'item_type1',
        'item_type2',
        'item_type3',
        'item_type4',
        'item_cust_price',
        'item_price',
        'item_point_type',
        'item_point',
        'item_supply_point',
        'item_use',
        'item_nocoupon',
        'item_soldout',
        'item_stock_qty',
        'item_tel_inq',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}
