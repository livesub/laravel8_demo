<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->integer('vi_id')->default(0)->comment('순번');
            $table->string('vi_ip')->nullable()->comment('아이피');
            $table->text('vi_referer')->comment('방문전 사이트');
            $table->string('vi_agent')->comment('agent');
            $table->string('vi_browser')->comment('browser');
            $table->string('vi_os')->comment('os');
            $table->string('vi_device')->comment('device');
            $table->string('vi_city')->comment('city');
            $table->string('vi_country')->comment('country');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
