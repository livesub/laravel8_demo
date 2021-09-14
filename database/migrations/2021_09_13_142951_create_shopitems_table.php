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
            $table->string('item_description')->nullable()->comment('기본 설명');
            $table->tinyInteger('item_type1')->length(1)->default(0)->comment('상품유형 : 히트');
            $table->tinyInteger('item_type2')->length(1)->default(0)->comment('상품유형 : 신상품');
            $table->tinyInteger('item_type3')->length(1)->default(0)->comment('상품유형 : 인기');
            $table->tinyInteger('item_type4')->length(1)->default(0)->comment('상품유형 : 할인');
            $table->string('item_manufacture')->nullable()->comment('제조사');
            $table->string('item_origin')->nullable()->comment('원산지');
            $table->tinyInteger('item_tel_inq')->length(1)->default(0)->comment('전화문의');
            $table->tinyInteger('item_use')->length(1)->default(0)->comment('판매가능');
            $table->tinyInteger('item_nocoupon')->length(1)->default(0)->comment('쿠폰적용안함');
            $table->integer('item_price')->default(0)->comment('판매가격');
            $table->integer('item_cust_price')->default(0)->comment('시중가격');
            $table->tinyInteger('item_point_type')->length(1)->default(0)->comment('포인트 유형');
            $table->integer('item_point')->default(0)->comment('포인트');
            $table->tinyInteger('item_soldout')->length(1)->default(0)->comment('상품품절');
            $table->integer('item_stock_qty')->default(0)->comment('재고수량');

            $table->enum('item_display', ['N', 'Y'])->length(2)->default('Y')->comment('출력 여부 : N=>미출력,Y=>출력');
            $table->integer('item_rank')->default(0)->length(3)->comment('출력순서: 높을수록 먼저 나옴');
            $table->text('item_content')->comment('내용');
            $table->text('item_img')->nullable()->comment('상품 변경파일이름(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img')->nullable()->comment('상품 원본파일이름');
            $table->timestamps();
            $table->index(['sca_id','item_code']);
        });
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
