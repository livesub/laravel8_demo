<?php
#############################################################################
#
#		파일이름		:		SessionDelController.php
#		파일설명		:		관리자 세션 파일 삭제 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 07일
#		최종수정일		:		2021년 09월 07일
#
###########################################################################-->

namespace App\Http\Controllers\adm\session_del;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;


class SessionDelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        flush();

        $dir = @opendir('../storage/framework/sessions');


        while($file=readdir($dir)) {
            $session_file = '../storage/framework/sessions/'.$file;

            if (!$atime=@fileatime($session_file)) {
                continue;
            }

            if (time() > $atime + (3600 * 24)) {  // 지난시간을 초로 계산해서 적어주시면 됩니다. default : 24시간전
                $return = unlink($session_file);

                flush();
            }
        }

        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$board_editor['editor']['del_ok']);
        exit;
    }
}
