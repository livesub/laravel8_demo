<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopUniqidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_uniqids', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->bigInteger('uq_id')->unique()->comment('unique 키');
            $table->string('uq_ip')->comment('아이피');
            $table->timestamps();
            $table->index('uq_id');
        });

        DB::statement("ALTER TABLE shop_uniqids comment '장바구니 unique 키'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_uniqids');
    }
}
