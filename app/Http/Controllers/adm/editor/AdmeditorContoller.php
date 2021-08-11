<?php

namespace App\Http\Controllers\adm\editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

use App\Models\boardmanager;    //모델 정의(게시판 관리 테이블)
use App\Models\board_datas_table;    //게시판 모델 정의
use App\Models\board_datas_comment_table;    //게시판 모델 정의
use App\Models\items;    //상품 모델 정의

class AdmeditorContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy()
    {
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //현재 게시판에만 쓰였지만 다른 곳에 쓰일 경우 계속 추가 해야 함
        //먼저 게시판 정보를 읽어 옴
        $board_set_infos = DB::table('boardmanagers')->select('bm_tb_name')->get();

        foreach ($board_set_infos as $board_set_info) {
            //var_dump($board_set_info->bm_tb_name);
            $path = "";
            $k = 0;
            $files = "";
            $editor_no_regi_img = array();

            $path = "data/board/{$board_set_info->bm_tb_name}/editor/";

            //서버 스마트 에디터 저장 경로에 있는 파일 모두 찾음
            if(is_dir($path)) {
                $files = array_values(array_diff(scandir($path), array(".", "..", "tmp")));

                for($j = 0; $j < count($files); $j++){
                    $board_like = DB::table('board_datas_tables')->where([['bm_tb_name',$board_set_info->bm_tb_name],['bdt_content', 'LIKE', "%{$files[$j]}%"]])->count();

                    if($board_like == 0){   //db 에 저장된 이미지가 아닌것만 배열로 만든다.
                        $editor_no_regi_img[$k] = $files[$j];
                        $k++;
                    }
                }
            }

            for($p = 0; $p < count($editor_no_regi_img); $p++){ //저장 되지 않은 이미지들 돌리며 삭제
                $editor_del_file_path = $path.$editor_no_regi_img[$p];

                if (file_exists($editor_del_file_path)) {
                    @unlink($editor_del_file_path); //이미지 삭제
                }
            }
        }

        //상품 관리 일때
        $k_item = 0;
        $path_item = "data/item/editor/";
        $editor_no_regi_img_item = array();

        if(is_dir($path_item)) {
            $files_item = array_values(array_diff(scandir($path_item), array(".", "..", "tmp")));
            for($j_item = 0; $j_item < count($files_item); $j_item++){
                $item_like = DB::table('items')->where('item_content', 'LIKE', "%{$files_item[$j_item]}%")->count();

                if($item_like == 0){   //db 에 저장된 이미지가 아닌것만 배열로 만든다.
                    $editor_no_regi_img_item[$k] = $files_item[$j_item];
                    $k_item++;
                }

                for($p_item = 0; $p_item < count($editor_no_regi_img_item); $p_item++){ //저장 되지 않은 이미지들 돌리며 삭제
                    $editor_del_file_path_item = $path_item.$editor_no_regi_img_item[$p_item];

                    if (file_exists($editor_del_file_path_item)) {
                        @unlink($editor_del_file_path_item); //이미지 삭제
                    }
                }
            }
        }

        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$board_editor['editor']['del_ok']);
        exit;
    }
}
