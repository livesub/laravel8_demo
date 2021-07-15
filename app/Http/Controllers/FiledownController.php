<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Facades\Response;


class FiledownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function index($token = null)
    //public function store(Request $request)
    public function store($type)
    {
        //원하는 첨부파일 경로와 순번 값을 함쳐서 보낸것을 짜른다.
        $type_cut = explode('_',$type);

        $data = User::whereId($type_cut[1])->first();
        $filepath = public_path('/data/member/').$data->user_imagepath;

        return Response::download($filepath, $data->user_ori_imagepath);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
