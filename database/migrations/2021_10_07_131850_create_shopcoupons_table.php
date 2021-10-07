<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopcouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopcoupons', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->bigInteger('cp_id')->comment('쿠폰아이디');
            $table->string('cp_subject')->comment('쿠폰이름');
            $table->integer('cp_method')->length(4)->default(0)->comment('쿠폰종류');
            $table->string('cp_target')->comment('쿠폰적용 상품 또는 분류');
            $table->string('user_id')->comment('아이디');
            $table->integer('cz_id')->default(0)->comment('일반쿠폰:0, 다운로드쿠폰:1');
            $table->string('cp_start')->comment('사용시작일');
            $table->string('cp_end')->comment('사용종료일');
            $table->integer('cp_price')->default(0)->comment('할인금액');
            $table->integer('cp_type')->length(4)->default(0)->comment('쿠폰타입');
            $table->integer('cp_minimum')->default(0)->comment('최소주문금액');
            $table->integer('cp_maximum')->default(0)->comment('최대할인금액');
            $table->bigInteger('od_id')->comment('사용한 장바구니 키');
            $table->timestamps();

            $table->index(['cp_id','user_id']);
        });

        DB::statement("ALTER TABLE shopcarts comment '쿠폰관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopcoupons');
    }
}
