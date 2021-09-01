<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;

class socialLoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redirect() {
        $parameters = ['access_type' => 'offline', "prompt" => "consent select_account"];
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/forms'])
            ->with($parameters)// refresh token
            ->redirect();
    }

    public function callback(Request $request) {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $social_info = Socialite::driver('google')->user();

        $user_info = DB::table('users')->where('user_id', $social_info->email)->count();

        if($user_info != 1){
            $create_result = User::create([
                'user_id'           => trim($social_info->email),
                'user_name'         => $social_info->name,
                'user_activated'    => 1,
                'user_level'        => 10,
                'user_type'         => 'N',
            ])->exists(); //저장,실패 결과 값만 받아 오기 위해  exists() 를 씀
        }else{
            return redirect()->route('main.index')->with('alert_messages', $Messages::$social['join_fail']);
        }
    }
}
