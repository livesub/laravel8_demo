<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popups', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->integer('pop_disable_hours')->default(0)->comment('다시 보지 않음을 선택할 시 몇 시간동안 보여주지 않을지 설정');
            $table->dateTime('pop_start_time')->comment('시작일시');
            $table->dateTime('pop_end_time')->comment('종료일시');
            $table->integer('pop_left')->default(0)->comment('팝업레이어 좌측 위치');
            $table->integer('pop_top')->default(0)->comment('팝업레이어 상단 위치');
            $table->integer('pop_width')->default(0)->comment('팝업레이어 넓이');
            $table->integer('pop_height')->default(0)->comment('팝업레이어 높이');
            $table->string('pop_subject')->comment('제목');
            $table->text('pop_content')->comment('내용');
            $table->enum('pop_display', ['N', 'Y'])->length(2)->default('Y')->comment('출력 여부 : N=>미출력,Y=>출력');
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
        Schema::dropIfExists('popups');
    }
}
