<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopcartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopcarts', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->bigInteger('od_id')->comment('장바구니 unique 키');
            $table->string('user_id')->comment('아이디');
            $table->string('item_code')->comment('상품코드');
            $table->string('item_name')->comment('상품명');
            $table->tinyInteger('item_sc_type')->length(1)->default(0)->comment('배송비 유형');
            $table->tinyInteger('item_sc_method')->length(1)->default(0)->comment('배송비결제 타입');
            $table->integer('item_sc_price')->default(0)->comment('기본배송비');
            $table->integer('item_sc_minimum')->default(0)->comment('배송비 상세조건:주문금액');
            $table->integer('item_sc_qty')->default(0)->comment('배송비 상세조건:주문수량');
            $table->string('sct_status')->comment('장바구니 상태');
            $table->text('sct_history')->comment('기록');
            $table->integer('sct_price')->default(0)->comment('판매가격');
            $table->integer('sct_point')->default(0)->comment('포인트');
            $table->tinyInteger('sct_point_use')->length(0)->default(0)->comment('포인트사용여부');
            $table->tinyInteger('sct_stock_use')->length(0)->default(0)->comment('재고 차감을 했는지 여부');
            $table->string('sct_option')->comment('상품명 또는 옵션명');
            $table->integer('sct_qty')->default(0)->comment('수량');
            $table->text('sio_id')->comment('옵션항목 조합');
            $table->tinyInteger('sio_type')->length(1)->default(0)->comment('옵션타입 : 0=>선택옵션,1=>추가옵션');
            $table->integer('sio_price')->default(0)->comment('옵션 추가금액');
            $table->string('sct_ip')->comment('아이피');
            $table->tinyInteger('sct_send_cost')->length(1)->default(0)->comment('배송비 : 1=>착불,2=>무료,3=>선불');
            $table->tinyInteger('sct_direct')->length(1)->default(0)->comment('바로구매 체크 : 0=>담기,1=>바로구매');
            $table->tinyInteger('sct_select')->length(1)->default(0)->comment('구매진행 체크');
            $table->string('sct_select_time')->comment('담긴 상품 중 주문하기를 실행한 시각');
            $table->timestamps();

            $table->index(['od_id','item_code','sct_status']);
        });

        DB::statement("ALTER TABLE shopcarts comment '장바구니'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopcarts');
    }
}
