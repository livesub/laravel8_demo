<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopitems', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('sca_id')->comment('카테고리');
            $table->string('item_code')->unique()->comment('상품코드');
            $table->string('item_name')->comment('상품명');
            $table->string('item_basic')->nullable()->comment('기본 설명');
            $table->string('item_manufacture')->nullable()->comment('제조사');
            $table->string('item_origin')->nullable()->comment('원산지');
            $table->string('item_brand')->nullable()->comment('브랜드');
            $table->string('item_model')->nullable()->comment('모델');
            $table->text('item_option_subject')->nullable()->comment('상품선택옵션 콤마로 저장');
            $table->text('item_supply_subject')->nullable()->comment('상품추가옵션 콤마로 저장');
            $table->tinyInteger('item_type1')->length(1)->default(0)->comment('상품유형:히트');
            $table->tinyInteger('item_type2')->length(1)->default(0)->comment('상품유형:신상품');
            $table->tinyInteger('item_type3')->length(1)->default(0)->comment('상품유형:인기');
            $table->tinyInteger('item_type4')->length(1)->default(0)->comment('상품유형:할인');
            $table->text('item_content')->comment('상품내용');
            $table->integer('item_cust_price')->default(0)->comment('시중가격');
            $table->integer('item_price')->default(0)->comment('판매가격');
            $table->tinyInteger('item_point_type')->length(1)->default(0)->comment('포인트 유형');
            $table->integer('item_point')->default(0)->comment('포인트');
            $table->integer('item_supply_point')->default(0)->comment('추가옵션상품 포인트');
            $table->tinyInteger('item_use')->length(1)->default(0)->comment('판매가능');
            $table->tinyInteger('item_nocoupon')->length(1)->default(0)->comment('쿠폰적용안함');
            $table->tinyInteger('item_soldout')->length(1)->default(0)->comment('상품품절');
            $table->integer('item_stock_qty')->default(0)->comment('재고수량');
            $table->tinyInteger('item_sc_type')->length(1)->default(0)->comment('배송비 유형');
            $table->tinyInteger('item_sc_method')->length(1)->default(0)->comment('배송비결제 타입');
            $table->integer('item_sc_price')->default(0)->comment('기본배송비');
            $table->integer('item_sc_minimum')->default(0)->comment('배송비 상세조건:주문금액');
            $table->integer('item_sc_qty')->default(0)->comment('배송비 상세조건:주문수량');
            $table->tinyInteger('item_tel_inq')->length(1)->default(0)->comment('전화문의');
            $table->enum('item_display', ['N', 'Y'])->length(2)->default('Y')->comment('출력 여부 : N=>미출력,Y=>출력');
            $table->integer('item_rank')->default(0)->length(3)->comment('출력순서: 높을수록 먼저 나옴');
            $table->text('item_img1')->nullable()->comment('상품 변경파일이름1(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img1')->nullable()->comment('상품 원본파일이름1');
            $table->text('item_img2')->nullable()->comment('상품 변경파일이름2(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img2')->nullable()->comment('상품 원본파일이름2');
            $table->text('item_img3')->nullable()->comment('상품 변경파일이름3(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img3')->nullable()->comment('상품 원본파일이름3');
            $table->text('item_img4')->nullable()->comment('상품 변경파일이름4(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img4')->nullable()->comment('상품 원본파일이름4');
            $table->text('item_img5')->nullable()->comment('상품 변경파일이름5(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img5')->nullable()->comment('상품 원본파일이름5');
            $table->text('item_img6')->nullable()->comment('상품 변경파일이름6(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img6')->nullable()->comment('상품 원본파일이름6');
            $table->text('item_img7')->nullable()->comment('상품 변경파일이름7(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img7')->nullable()->comment('상품 원본파일이름7');
            $table->text('item_img8')->nullable()->comment('상품 변경파일이름8(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img8')->nullable()->comment('상품 원본파일이름8');
            $table->text('item_img9')->nullable()->comment('상품 변경파일이름9(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img9')->nullable()->comment('상품 원본파일이름9');
            $table->text('item_img10')->nullable()->comment('상품 변경파일이름10(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img10')->nullable()->comment('상품 원본파일이름10');
            $table->timestamps();
            $table->index(['sca_id','item_code']);
        });

        DB::statement("ALTER TABLE shopitems comment 'shop 상품관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopitems');
    }
}
