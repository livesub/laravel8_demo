<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::group(['prefix' => '{locale}'], function () {
    Route::get('home','Controller@method');
    Route::get('otherurl','Controller@method');
});
*/

Route::get('/', [
    'as' => 'main.index',
    'uses' => 'App\Http\Controllers\MainController@index',
]);

Route::get('/home', [
    'as' => 'home.index',
    'uses' => 'App\Http\Controllers\MainController@index',
]);

/* 로그인이 되지 않은 페이지에 접근 했을시에 로그인 페이지로 이동 */
Route::get('login', [
    'as' => 'login',
    'uses' => 'App\Http\Controllers\auth\LoginController@index',
]);

/* 다국어 변환 */
Route::get('multilingual/{type}', [
    'as' => 'multilingual',
    'uses' => 'App\Http\Controllers\Multilingual_session@store',
]);

/*
Route::get('{locale}', function ($locale) {
    App::setLocale($locale);
    return view('auth/login');
});
*/

/* 사용자 등록 */
Route::get('auth/join', [
    'as' => 'join.create',  //form 같은 곳에서 {{ route('join.store') }}  쓰기 위해
    'uses' => 'App\Http\Controllers\auth\JoinController@index',
]);

Route::post('auth/join', [
    'as' => 'join.store',
    'uses' => 'App\Http\Controllers\auth\JoinController@store',
]);

/* 이메일 인증 리턴 */
Route::get('auth/confirm/{code}',[
    'as' => 'join.confirm',
    'uses' => 'App\Http\Controllers\auth\JoinController@confirm',
]);

/* 사용자 로그인 */
Route::get('auth/login', [
    'as' => 'login.index',
    'uses' => 'App\Http\Controllers\auth\LoginController@index',
]);

Route::post('auth/login', [
    'as' => 'login.store',
    'uses' => 'App\Http\Controllers\auth\LoginController@store',
]);

/* 사용자 아웃 */
Route::get('auth/logout', [
    'as' => 'logout.destroy',
    'uses' => 'App\Http\Controllers\auth\LoginController@destroy',
]);

/* 비번 찾기 */
Route::get('auth/pwchange', [
    'as' => 'pwchange.index',
    'uses' => 'App\Http\Controllers\auth\PwchangeController@index',
]);

Route::post('auth/pwchange', [
    'as' => 'pwchange.store',
    'uses' => 'App\Http\Controllers\auth\PwchangeController@store',
]);

/*비밀번호 변경 리턴 */
Route::get('auth/reset/{token}', [
    'as' => 'reset.index',
    'uses' => 'App\Http\Controllers\auth\ResetController@index',
]);

Route::post('auth/reset', [
    'as' => 'reset.store',
    'uses' => 'App\Http\Controllers\auth\ResetController@store',
]);

/* 로그인 사용자만 볼수 있는 페이지를 group 로 묶는다 */
Route::group(['middleware' => ['auth']], function () {
    /* 마이페이지 */
    Route::get('member/mypage', [
        'as' => 'mypage.index',
        'uses' => 'App\Http\Controllers\member\MypageController@index',
    ]);

    Route::post('member/mypage', [
        'as' => 'mypage.pw_change',
        'uses' => 'App\Http\Controllers\member\MypageController@pw_change',
    ]);

    Route::post('member/infosave', [
        'as' => 'mypage.infosave',
        'uses' => 'App\Http\Controllers\member\InfosaveController@store',
    ]);

    //type = member_id = 순번
    Route::get('filedown/{type}', [
        'as' => 'filedown',
        'uses' => 'App\Http\Controllers\FiledownController@store',
    ]);
 });


/*** 관리자 페이지 접근 ***/
Route::get('adm/', [
    'as' => 'adm.index',
    'uses' => 'App\Http\Controllers\adm\AdmController@index',
]);

Route::get('adm/login', [
    'as' => 'adm.login.index',
    'uses' => 'App\Http\Controllers\adm\AdmloginController@index',
]);

Route::post('adm/login', [
    'as' => 'adm.login.store',
    'uses' => 'App\Http\Controllers\adm\AdmloginController@store',
]);

/* 로그인 사용자만 볼수 있는 페이지를 group 로 묶는다(관리자) */
Route::group(['middleware' => ['auth']], function () {
    /* 회원 리스트 */
    Route::get('adm/member', [
        'as' => 'adm.member.index',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@index',
    ]);

    /* 회원 등록 */
    Route::get('adm/member/member_regi', [  //등록,수정 같이 씀
        'as' => 'adm.member.show',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@show',
    ]);

    Route::post('adm/member/member_regi', [ //등록,수정 처리
        'as' => 'adm.member.regi.store',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@store',
    ]);


    Route::post('adm/member/member_pw_change', [    //비번변경
        'as' => 'adm.member.pw_change',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@pw_change',
    ]);

    Route::post('adm/member/member_img_del', [    //이미지 삭제
        'as' => 'adm.member.imgdel',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@imgdel',
    ]);

    Route::post('adm/member/member_out', [    //회원 탈퇴
        'as' => 'adm.member.out',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@member_out',
    ]);
/*** 관리자 회원 관련 끝 */



/*** 관리자 게시판 관리 */
    Route::get('adm/boardmanage', [     //리스트
        'as' => 'adm.boardmanage.index',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@index',
    ]);

    Route::post('adm/boardmanage/boardadd', [   //게시판 생성
        'as' => 'adm.boardmanage.create',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@create',
    ]);

    Route::post('adm/boardmanage/boardshow', [   //게시판 설정 view
        'as' => 'adm.boardmanage.show',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@show',
    ]);

    Route::post('adm/boardmanage/boardstore', [   //게시판 설정 저장
        'as' => 'adm.boardmanage.store',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@store',
    ]);

    Route::post('adm/boardmanage/boarddel', [   //게시판 삭제
        'as' => 'adm.boardmanage.destroy',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@destroy',
    ]);

    Route::get('adm/admboard/list/{tb_name}', [  //게시판 리스트
        'as' => 'adm.admboard.index',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@index',
    ]);

    Route::post('adm/admboard/list/choice_del', [  //게시판 리스트 에서 관리자 선택 삭제
        'as' => 'adm.admboard.choice_del',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@choice_del',
    ]);

    Route::get('adm/admboard/write/{tb_name}', [  //게시판 글쓰기
        'as' => 'adm.admboard.create',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@create',
    ]);

    Route::post('adm/admboard/write/', [  //게시판 글쓰기 저장
        'as' => 'adm.admboard.store',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@store',
    ]);

    Route::get('adm/admboard/view/{tb_name}', [  //게시판 view
        'as' => 'adm.admboard.show',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@show',
    ]);

    Route::get('adm/admboard/secret/{tb_name}', [  //게시판 비밀글 처리
        'as' => 'adm.admboard.secret',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@secret',
    ]);

    Route::post('adm/admboard/secretpw/', [  //게시판 비밀글 처리
        'as' => 'adm.admboard.secretpw',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@secretpw',
    ]);

    Route::post('adm/admboard/downloadfile/', [  //게시판 첨부파일 다운로드 처리
        'as' => 'adm.admboard.downloadfile',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@downloadfile',
    ]);

    Route::get('adm/admboard/reply/{tb_name}/{ori_num}', [  //게시판 답글 쓰기
        'as' => 'adm.admboard.reply',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@reply',
    ]);

    Route::post('adm/admboard/replysave/{tb_name}', [  //게시판 답글 저장
        'as' => 'adm.admboard.replysave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@replysave',
    ]);

    Route::get('adm/admboard/modify/{tb_name}/{ori_num}', [  //게시판 수정
        'as' => 'adm.admboard.modify',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@modify',
    ]);

    Route::post('adm/admboard/modifysave/{tb_name}', [  //게시판 수정 저장
        'as' => 'adm.admboard.modifysave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@modifysave',
    ]);

    Route::post('adm/admboard/delete/{tb_name}', [  //게시판 삭제 처리
        'as' => 'adm.admboard.deletesave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@deletesave',
    ]);

    Route::post('adm/admboard/commemt/{tb_name}', [  //게시판 댓글 처리
        'as' => 'adm.admboard.commentsave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@commentsave',
    ]);

    Route::post('adm/admboard/commemtreply/{tb_name}', [  //게시판 댓글에 답글 처리
        'as' => 'adm.admboard.commemtreplysave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@commemtreplysave',
    ]);

    Route::post('adm/admboard/commemtmodify/{tb_name}', [  //게시판 댓글 수정 처리
        'as' => 'adm.admboard.commemtmodifysave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@commemtmodifysave',
    ]);

    Route::post('adm/admboard/commemtdelete/{tb_name}', [  //게시판 댓글 삭제 처리
        'as' => 'adm.admboard.commemtdelete',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardContoller@commemtdelete',
    ]);

    Route::get('adm/editor', [  //스마트 에디터를 통해 남아 있는 불필요 파일 제거
        'as' => 'adm.editor.delete',
        'uses' => 'App\Http\Controllers\adm\editor\AdmeditorContoller@destroy',
    ]);

/*** 관리자 카테고리 관리 */
    Route::get('adm/cate', [
        'as' => 'adm.cate.indx',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateContoller@index',
    ]);

    Route::get('adm/cateadd', [
        'as' => 'adm.cate.addcategory',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateContoller@addcategory',
    ]);

    Route::post('adm/cateaddsave', [
        'as' => 'adm.cate.addcategorysave',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateContoller@addcategorysave',
    ]);

});


/*** 프론트 게시판 관리 */
Route::get('board/list/{tb_name}', [  //게시판 리스트
    'as' => 'board.index',
    'uses' => 'App\Http\Controllers\board\BoardContoller@index',
]);

Route::post('board/list/choice_del', [  //게시판 리스트 에서 관리자 선택 삭제
    'as' => 'board.choice_del',
    'uses' => 'App\Http\Controllers\board\BoardContoller@choice_del',
]);

Route::get('board/write/{tb_name}', [  //게시판 글쓰기
    'as' => 'board.create',
    'uses' => 'App\Http\Controllers\board\BoardContoller@create',
]);

Route::post('board/write/', [  //게시판 글쓰기 저장
    'as' => 'board.store',
    'uses' => 'App\Http\Controllers\board\BoardContoller@store',
]);

Route::get('board/view/{tb_name}', [  //게시판 view
    'as' => 'board.show',
    'uses' => 'App\Http\Controllers\board\BoardContoller@show',
]);

Route::get('board/secret/{tb_name}', [  //게시판 비밀글 처리
    'as' => 'board.secret',
    'uses' => 'App\Http\Controllers\board\BoardContoller@secret',
]);

Route::post('board/secretpw/', [  //게시판 비밀글 처리
    'as' => 'board.secretpw',
    'uses' => 'App\Http\Controllers\board\BoardContoller@secretpw',
]);

Route::post('board/downloadfile/', [  //게시판 첨부파일 다운로드 처리
    'as' => 'board.downloadfile',
    'uses' => 'App\Http\Controllers\board\BoardContoller@downloadfile',
]);

Route::get('board/reply/{tb_name}/{ori_num}', [  //게시판 답글 쓰기
    'as' => 'board.reply',
    'uses' => 'App\Http\Controllers\board\BoardContoller@reply',
]);

Route::post('board/replysave/{tb_name}', [  //게시판 답글 저장
    'as' => 'board.replysave',
    'uses' => 'App\Http\Controllers\board\BoardContoller@replysave',
]);

Route::get('board/modify/{tb_name}/{ori_num}', [  //게시판 수정
    'as' => 'board.modify',
    'uses' => 'App\Http\Controllers\board\BoardContoller@modify',
]);

Route::post('board/modifysave/{tb_name}', [  //게시판 수정 저장
    'as' => 'board.modifysave',
    'uses' => 'App\Http\Controllers\board\BoardContoller@modifysave',
]);

Route::post('board/delete/{tb_name}', [  //게시판 삭제 처리
    'as' => 'board.deletesave',
    'uses' => 'App\Http\Controllers\board\BoardContoller@deletesave',
]);

Route::post('board/commemt/{tb_name}', [  //게시판 댓글 처리
    'as' => 'board.commentsave',
    'uses' => 'App\Http\Controllers\board\BoardContoller@commentsave',
]);

Route::post('board/commemtreply/{tb_name}', [  //게시판 댓글에 답글 처리
    'as' => 'board.commemtreplysave',
    'uses' => 'App\Http\Controllers\board\BoardContoller@commemtreplysave',
]);

Route::post('board/commemtmodify/{tb_name}', [  //게시판 댓글 수정 처리
    'as' => 'board.commemtmodifysave',
    'uses' => 'App\Http\Controllers\board\BoardContoller@commemtmodifysave',
]);

Route::post('board/commemtdelete/{tb_name}', [  //게시판 댓글 삭제 처리
    'as' => 'board.commemtdelete',
    'uses' => 'App\Http\Controllers\board\BoardContoller@commemtdelete',
]);