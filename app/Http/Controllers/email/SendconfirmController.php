<?php

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
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index($token = null)
    {
        $email = email_sends::whereEmailReceiveToken($token)->first();

        $email->email_receive_chk = 'Y';
        $email->email_receive_token = '';
        $email->save();
    }
}
