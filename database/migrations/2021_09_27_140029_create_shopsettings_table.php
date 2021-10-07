<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopsettings', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('company_name')->nullable()->comment('회사명');
            $table->string('company_saupja_no')->nullable()->comment('사업자 등록번호');
            $table->string('company_owner')->nullable()->comment('대표자명');
            $table->string('company_tel')->nullable()->comment('대표전화번호');
            $table->string('company_fax')->nullable()->comment('팩스번호');
            $table->string('company_tongsin_no')->nullable()->comment('통신판매업 신고 번호');
            $table->string('company_buga_no')->nullable()->comment('부가통신 사업자번호');
            $table->string('company_zip')->nullable()->comment('사업장 우편번호');
            $table->string('company_addr')->nullable()->comment('사업장 주소');
            $table->string('company_info_name')->nullable()->comment('정보관리책임자명');
            $table->string('company_info_email')->nullable()->comment('정보책임자이메일');
            $table->tinyInteger('company_bank_use')->length(1)->default(1)->comment('무통장입금사용:0=>사용안함,1=>사용함');
            $table->text('company_bank_account')->nullable()->comment('은행계좌번호');
            $table->tinyInteger('company_use_point')->length(1)->default(1)->comment('포인트 사용');

            $table->tinyInteger('member_reg_coupon_use')->length(1)->default(0)->comment('회원가입 쿠폰 사용유무');
            $table->integer('member_reg_coupon_price')->default(0)->comment('쿠폰 금액');
            $table->integer('member_reg_coupon_minimum')->default(0)->comment('주문최소금액');
            $table->integer('member_reg_coupon_term')->default(0)->comment('쿠폰유효기간');

            $table->string('shop_img_width')->nullable()->comment('이미지리사이징-넓이');
            $table->string('shop_img_height')->nullable()->comment('이미지리사이징-높이');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE shopsettings comment 'shop 환경 설정'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopsettings');
    }
}
