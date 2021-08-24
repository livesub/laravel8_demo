<?php
#############################################################################
#
#		파일이름		:		SendconfirmController.php
#		파일설명		:		회원 가입시 발송한 이메일 인증 confirm
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers\email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use App\Models\email_sends;    //모델 정의

class SendconfirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index($token = null)
    {
        $email = email_sends::whereEmailReceiveToken($token)->first();

        $email->email_receive_chk = 'Y';
        $email->email_receive_token = '';
        $email->save();
    }
}
