<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menuses', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('menu_id')->unique()->comment('메뉴 카테고리');
            $table->string('menu_name_en')->unique()->comment('메뉴 카테고리 영어명');
            $table->string('menu_name_kr')->comment('메뉴 카테고리 한글명');
            $table->enum('menu_page_type', ['P', 'B', 'I'])->length(2)->default('P')->comment('메뉴 페이지 타입 : P=>일반 HTML,B=>게시판페이지,I=>상품페이지');
            $table->enum('menu_display', ['N', 'Y'])->length(2)->default('Y')->comment('메뉴 출력 여부 : N=>미출력,Y=>출력');
            $table->integer('menu_rank')->default(0)->length(3)->comment('메뉴 출력순서: 높을수록 먼저 나옴');
            $table->text('menu_content')->comment('내용');
            $table->timestamps();
            $table->index(['menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menuses');
    }
}
