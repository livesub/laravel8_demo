<?php
#############################################################################
#
#		파일이름		:		Multilingual_sessionController.php
#		파일설명		:		언어팩 변경 session control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Multilingual_session extends Controller
{
    public function store($type)
    {
        session()->put('multi_lang', $type);
        return redirect('/');
    }

}
