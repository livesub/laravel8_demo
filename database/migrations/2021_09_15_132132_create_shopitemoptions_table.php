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
            $table->integer('sio_type')->default(0)->comment('옵션타입 : 0=>선택옵션,1=>추가옵션');







            $table->timestamps();
            $table->index(['sca_id','item_code']);
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
