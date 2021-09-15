<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembervisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membervisits', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->integer('mv_id')->default(0)->comment('순번');
            $table->string('user_id')->comment('유저 아이디');
            $table->string('mv_ip')->nullable()->comment('아이피');
            $table->text('mv_referer')->comment('방문전 사이트');
            $table->string('mv_agent')->comment('agent');
            $table->string('mv_browser')->comment('browser');
            $table->string('mv_os')->comment('os');
            $table->string('mv_device')->comment('device');
            $table->string('mv_city')->comment('city');
            $table->string('mv_country')->comment('country');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE membervisits comment '회원 접속 통계'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membervisits');
    }
}
