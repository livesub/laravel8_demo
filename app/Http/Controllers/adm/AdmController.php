<?php
#############################################################################
#
#		파일이름		:		AdminController.php
#		파일설명		:		관리자페이지 로그인 설정
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Http\Controllers\adm;
use App\Http\Middleware;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class AdmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(function () {
            $this->user = Auth::user();

            if(!$this->user){
                //로그인이 되지 않았다면
                return redirect()->route('adm.login.index');
                exit;
            }else{
                //로그인이 되었다면..
                $admin_chk = CustomUtils::admin_access($this->user->user_level,config('app.ADMIN_LEVEL'));
                if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
                    return redirect()->route('main.index');
                    exit;
                }else{
                    return redirect()->route('adm.member.index');
                }
            }
        });
    }

}
