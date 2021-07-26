<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardDatasCommentTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_datas_comment_tables', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('bm_tb_name')->comment('테이블명');
            $table->integer('bdt_id')->comment('부모글 순번');
            $table->string('bdct_uid')->nullable()->comment('작성자 아이디');
            $table->string('bdct_uname')->nullable()->comment('작성자 이름');
            $table->text('bdct_memo')->comment('내용');
            $table->integer('bdct_grp')->length(5)->nullable()->default(0)->comment('댓글 그룹 판단-대댓글 표현');
            $table->integer('bdct_sort')->length(5)->nullable()->default(0)->comment('댓글 정렬-대댓글 표현');
            $table->integer('bdct_depth')->length(5)->nullable()->default(0)->comment('댓글 깊이-대댓글 표현');
            $table->string('bdct_ip')->comment('작성자 ip');
            $table->timestamps();
            $table->index(['bm_tb_name','bdct_grp', 'bdct_sort','bdct_depth']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_datas_comment_tables');
    }
}
