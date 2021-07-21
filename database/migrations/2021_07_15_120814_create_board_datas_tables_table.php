<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardDatasTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_datas_tables', function (Blueprint $table) {
            $table->id()->unique()->comment('순번');
            $table->string('bm_tb_name')->comment('테이블명');
            $table->integer('bdt_grp')->length(5)->nullable()->default(0)->comment('그룹 판단');
            $table->integer('bdt_sort')->length(5)->nullable()->default(0)->comment('정렬');
            $table->integer('bdt_depth')->length(5)->nullable()->default(0)->comment('깊이');
            $table->string('bdt_ip')->comment('작성자 ip');
            $table->tinyInteger('bdt_chk_secret')->length(1)->default(0)->comment('비밀글 사용 체크');
            $table->string('bdt_uid')->nullable()->comment('작성자 아이디');
            $table->string('bdt_uname')->nullable()->comment('작성자 이름');
            $table->string('bdt_upw')->nullable()->comment('작성자 비밀번호');
            $table->string('bdt_subject')->comment('제목');
            $table->text('bdt_content')->comment('내용');
            $table->string('bdt_category')->nullable()->comment('카테고리값');
            $table->integer('bdt_hit')->default(0)->comment('조회수');
            $table->integer('bdt_comment_cnt')->default(0)->comment('댓글수');
            $table->string('bdt_ori_file_name1')->nullable()->comment('원본 첨부파일 이름1');
            $table->text('bdt_file1')->nullable()->comment('첨부파일1(원본@@썸네일1@@썸네일2..)');
            $table->string('bdt_ori_file_name2')->nullable()->comment('원본 첨부파일 이름2');
            $table->text('bdt_file2')->nullable()->comment('첨부파일2(원본@@썸네일1@@썸네일2..)');
            $table->string('bdt_ori_file_name3')->nullable()->comment('원본 첨부파일 이름3');
            $table->text('bdt_file3')->nullable()->comment('첨부파일3(원본@@썸네일1@@썸네일2..)');
            $table->string('bdt_ori_file_name4')->nullable()->comment('원본 첨부파일 이름4');
            $table->text('bdt_file4')->nullable()->comment('첨부파일4(원본@@썸네일1@@썸네일2..)');
            $table->string('bdt_ori_file_name5')->nullable()->comment('원본 첨부파일 이름5');
            $table->text('bdt_file5')->nullable()->comment('첨부파일5(원본@@썸네일1@@썸네일2..)');
            $table->integer('bdt_down_cnt')->default(0)->comment('첨부 다운로드 횟수');
            $table->timestamps();
            $table->index(['bm_tb_name','bdt_grp', 'bdt_sort','bdt_depth']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_datas_tables');
    }
}
