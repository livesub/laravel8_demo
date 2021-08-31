<?php

namespace App\Http\Controllers\adm\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class AdmShopController extends Controller
{
    public function __construct()
    {
dd("svsdvsd");
        $this->middleware(function () {
            $this->user = Auth::user();

            if(!$this->user){
                //로그인이 되지 않았다면
                return redirect()->route('login.index');
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
