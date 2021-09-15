<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopitemoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopitemoptions', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->text('sio_id')->nullable()->comment('옵션항목 조합');
            $table->tinyInteger('sio_type')->length(1)->default(0)->comment('옵션타입 : 0=>선택옵션,1=>추가옵션');
            $table->string('item_code')->comment('상품코드');
            $table->integer('sio_price')->default(0)->comment('옵션 추가금액');
            $table->integer('sio_stock_qty')->default(0)->comment('옵션 재고수량');
            $table->integer('sio_noti_qty')->default(0)->comment('옵션 통보수량');
            $table->tinyInteger('sio_use')->length(1)->default(0)->comment('옵션사용여부');
            $table->timestamps();
            $table->index('item_code');
        });

        DB::statement("ALTER TABLE shopitemoptions comment 'shop 옵션관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopitemoptions');
    }
}
