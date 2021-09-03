<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use App\Models\menuses;    //메뉴 모델 정의

class MenuController extends Controller
{
    public function menu_list()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $one_step_infos = DB::table('menuses')->where('menu_display','Y')->whereRaw('length(menu_id) = 2')->orderby('menu_rank', 'DESC')->get();   //정보 읽기

        $customutils = new CustomUtils();

        return view('menu.menulist',[
            'one_step_infos'    => $one_step_infos,
            'customutils'       => $customutils,
        ]);
    }
}
