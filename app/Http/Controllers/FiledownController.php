<?php
#############################################################################
#
#		파일이름		:		FiledownController.php
#		파일설명		:		첨부파일 다운로드 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Facades\Response;

class FiledownController extends Controller
{
    public function store($type)
    {
        //원하는 첨부파일 경로와 순번 값을 함쳐서 보낸것을 짜른다.
        $type_cut = explode('_',$type);

        $data = User::whereId($type_cut[1])->first();
        $filepath = public_path('/data/member/').$data->user_imagepath;

        return Response::download($filepath, $data->user_ori_imagepath);
    }
}
