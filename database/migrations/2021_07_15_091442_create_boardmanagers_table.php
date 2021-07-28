<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardmanagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boardmanagers', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('bm_tb_name')->unique()->comment('테이블명');
            $table->string('bm_tb_subject')->comment('게시판 이름');
            $table->integer('bm_type')->length(2)->default(1)->comment('게시판 종류 : 1=>일반게시판, 2=>갤러리게시판');
            $table->integer('bm_record_num')->length(2)->default(10)->comment('한 페이지 게시물 갯수');
            $table->integer('bm_page_num')->nullable()->length(2)->default(10)->comment('한 페이지 출력될 페이지 갯수');
            $table->smallInteger('bm_subject_len')->length(3)->default(50)->comment('출력될 제목 길이');
            $table->smallInteger('bm_list_chk')->length(3)->default(100)->comment('리스트 가능 권한(100 손님)');
            $table->smallInteger('bm_write_chk')->length(3)->default(100)->comment('쓰기 가능 권한(100 손님)');
            $table->smallInteger('bm_view_chk')->length(3)->default(100)->comment('보기 가능 권한(100 손님)');
            $table->smallInteger('bm_modify_chk')->length(3)->default(100)->comment('수정 가능 권한(100 손님)');
            $table->smallInteger('bm_reply_chk')->length(3)->default(100)->comment('답글 가능 권한(100 손님)');
            $table->smallInteger('bm_delete_chk')->length(3)->default(100)->comment('삭제 가능 권한(100 손님)');
            $table->tinyInteger('bm_coment_type')->length(1)->default(1)->comment('댓글사용여부1=>사용');
            $table->tinyInteger('bm_secret_type')->length(1)->default(0)->comment('비밀글사용여부0=>비사용,1=>사용');
            $table->string('bm_category_key')->nullable()->comment('카테고리 키값');
            $table->string('bm_category_ment')->nullable()->comment('카테고리 이름값');
            $table->tinyInteger('bm_file_num')->length(2)->default(1)->comment('첨부파일 사용개수');
            $table->string('bm_resize_file_num')->nullable()->comment('첨부자료(이미지시) 리사이징 개수');
            $table->string('bm_resize_width_file')->nullable()->comment('리사이징될 가로 길이(리사이징 개수와 같아야함%%구분)');
            $table->string('bm_resize_height_file')->nullable()->comment('리사이징될 높이 길이(리사이징 개수와 같아야함%%구분)');
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
        Schema::dropIfExists('boardmanagers');
    }
}
