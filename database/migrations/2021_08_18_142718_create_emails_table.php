<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('email_subject')->comment('제목');
            $table->text('email_content')->comment('내용');
            $table->string('email_file1')->nullable()->comment('첨부 변경 파일이름');
            $table->string('email_ori_file1')->nullable()->comment('첨부 원본 파일이름');
            $table->string('email_file2')->nullable()->comment('첨부 변경 파일이름');
            $table->string('email_ori_file2')->nullable()->comment('첨부 원본 파일이름');
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
        Schema::dropIfExists('emails');
    }
}
