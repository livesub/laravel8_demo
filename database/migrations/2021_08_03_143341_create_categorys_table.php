<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorys', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('ca_id')->unique()->comment('카테고리');
            $table->string('ca_name_kr')->comment('카테고리 한글명');
            $table->string('ca_name_en')->comment('카테고리 영어명');
            $table->enum('ca_display', ['N', 'Y'])->length(2)->default('Y')->comment('출력 여부 : N=>미출력,Y=>출력');
            $table->integer('ca_rank')->default(0)->length(3)->comment('출력순서: 높을수록 먼저 나옴');
            $table->timestamps();
            $table->index(['ca_id']);
        });

        DB::statement("ALTER TABLE categorys comment '카테고리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorys');
    }
}
