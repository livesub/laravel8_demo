<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_sends', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->integer('email_id')->comment('email 순번');
            $table->string('email_user_id')->comment('회원 email');
            $table->enum('email_send_chk', ['N', 'Y'])->length(2)->default('Y')->comment('이메일 발송 여부 : N=>실패,Y=>성공');
            $table->enum('email_receive_chk', ['N', 'Y'])->length(2)->default('N')->comment('이메일 확인 여부 : N=>미확인,Y=>확인');
            $table->string('email_receive_token')->comment('이메일 확인 용도(이메일에 함께 보냄)');
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
        Schema::dropIfExists('email_sends');
    }
}
