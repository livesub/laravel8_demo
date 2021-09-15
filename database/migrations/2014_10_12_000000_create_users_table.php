<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('user_id')->unique()->comment('아이디');
            $table->string('password')->comment('비밀번호');    //$user_pw 을 사용 하면 로그인이 되지 않으므로 칼럼명을 password 로 바꾼다
            $table->string('user_name')->comment('이름');
            $table->string('user_phone')->comment('전화번호')->default('');
            $table->string('user_imagepath')->nullable()->comment('프로필사진 변경파일이름');
            $table->string('user_ori_imagepath')->nullable()->comment('프로필사진 원본파일이름');
            $table->string('user_thumb_name')->nullable()->comment('썸네일 파일 이름');
            $table->string('user_confirm_code',60)->nullable()->comment('이메일 확인');
            $table->boolean('user_activated')->default(0)->comment('가입 확인');
            $table->integer('user_level')->length(3)->default(10)->comment('사용자 레벨');
            $table->enum('user_type', ['N', 'Y'])->nullable()->length(2)->default('N')->comment('탈퇴여부:Y=>탈퇴');
            $table->string('user_platform_type')->nullable()->comment('소셜 로그인 방식');
            $table->timestamp('user_email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE users comment '회원관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
