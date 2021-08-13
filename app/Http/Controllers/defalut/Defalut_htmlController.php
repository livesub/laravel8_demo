<?php

namespace App\Http\Controllers\defalut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;

class Defalut_htmlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pg_name, Request $request)
    {
        $page_info = DB::table('menuses')->where('menu_name_en', $pg_name)->first();

        return view('defalut.defalut_page',[
            "menu_name_kr"      => $page_info->menu_name_kr,
            "menu_name_en"      => $page_info->menu_name_en,
            "menu_content"      => $page_info->menu_content,
        ]);
    }
}
