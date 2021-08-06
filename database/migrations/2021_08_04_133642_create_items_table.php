<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('ca_id')->comment('카테고리');
            $table->string('item_code')->unique()->comment('상품코드');
            $table->string('item_name')->comment('상품명');
            $table->enum('item_display', ['N', 'Y'])->length(2)->default('Y')->comment('출력 여부 : N=>미출력,Y=>출력');
            $table->integer('item_rank')->default(0)->length(3)->comment('출력순서: 높을수록 먼저 나옴');
            $table->text('item_content')->comment('내용');
            $table->text('item_img')->nullable()->comment('상품 변경파일이름(원본@@썸네일1@@썸네일2..)');
            $table->string('item_ori_img')->nullable()->comment('상품 원본파일이름');
            $table->timestamps();
            $table->index(['ca_id','item_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
