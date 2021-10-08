<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaesongjisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baesongjis', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('user_id')->comment('아이디');
            $table->string('ad_subject')->comment('배송지명');
            $table->integer('ad_default')->length(4)->default(0)->comment('기본배송지');
            $table->string('ad_name')->comment('받으시는 분 이름');
            $table->string('ad_tel')->comment('받으시는 분 전화번호');
            $table->string('ad_hp')->comment('받으시는 분 휴대폰번호');
            $table->char('ad_zip1')->length(5)->comment('받으시는 분 우편번호');
            $table->string('ad_addr1')->comment('받으시는 분 기본주소');
            $table->string('ad_addr2')->comment('받으시는 분 상세주소');
            $table->string('ad_addr3')->comment('받으시는 분 주소 참고 항목');
            $table->string('ad_jibeon')->comment('받으시는 분 지번주소');
            $table->timestamps();

            $table->index('user_id');
        });

        DB::statement("ALTER TABLE baesongjis comment '배송지이력관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baesongjis');
    }
}
