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

    //탈퇴 하기
    Route::get('member/withdraw', [
        'as' => 'mypage.withdraw',
        'uses' => 'App\Http\Controllers\member\MypageController@withdraw',
    ]);

 });

/* 이메일 확인 리턴(외부에서 접속 해야 하기에 밖으로 뺌) */
Route::get('email/{token}', [
    'as' => 'email.sendconfirm.index',
    'uses' => 'App\Http\Controllers\email\SendconfirmController@index',
]);


/*** 프론트 게시판 관리 */
Route::get('board/list/{tb_name}', [  //게시판 리스트
    'as' => 'board.index',
    'uses' => 'App\Http\Controllers\board\BoardController@index',
]);

Route::post('board/list/choice_del', [  //게시판 리스트 에서 관리자 선택 삭제
    'as' => 'board.choice_del',
    'uses' => 'App\Http\Controllers\board\BoardController@choice_del',
]);

Route::get('board/write/{tb_name}', [  //게시판 글쓰기
    'as' => 'board.create',
    'uses' => 'App\Http\Controllers\board\BoardController@create',
]);

Route::post('board/write/', [  //게시판 글쓰기 저장
    'as' => 'board.store',
    'uses' => 'App\Http\Controllers\board\BoardController@store',
]);

Route::get('board/view/{tb_name}', [  //게시판 view
    'as' => 'board.show',
    'uses' => 'App\Http\Controllers\board\BoardController@show',
]);

Route::get('board/secret/{tb_name}', [  //게시판 비밀글 처리
    'as' => 'board.secret',
    'uses' => 'App\Http\Controllers\board\BoardController@secret',
]);

Route::post('board/secretpw/', [  //게시판 비밀글 처리
    'as' => 'board.secretpw',
    'uses' => 'App\Http\Controllers\board\BoardController@secretpw',
]);

Route::post('board/downloadfile/', [  //게시판 첨부파일 다운로드 처리
    'as' => 'board.downloadfile',
    'uses' => 'App\Http\Controllers\board\BoardController@downloadfile',
]);

Route::get('board/reply/{tb_name}/{ori_num}', [  //게시판 답글 쓰기
    'as' => 'board.reply',
    'uses' => 'App\Http\Controllers\board\BoardController@reply',
]);

Route::post('board/replysave/{tb_name}', [  //게시판 답글 저장
    'as' => 'board.replysave',
    'uses' => 'App\Http\Controllers\board\BoardController@replysave',
]);

Route::get('board/modify/{tb_name}/{ori_num}', [  //게시판 수정
    'as' => 'board.modify',
    'uses' => 'App\Http\Controllers\board\BoardController@modify',
]);

Route::post('board/modifysave/{tb_name}', [  //게시판 수정 저장
    'as' => 'board.modifysave',
    'uses' => 'App\Http\Controllers\board\BoardController@modifysave',
]);

Route::post('board/delete/{tb_name}', [  //게시판 삭제 처리
    'as' => 'board.deletesave',
    'uses' => 'App\Http\Controllers\board\BoardController@deletesave',
]);

Route::post('board/commemt/{tb_name}', [  //게시판 댓글 처리
    'as' => 'board.commentsave',
    'uses' => 'App\Http\Controllers\board\BoardController@commentsave',
]);

Route::post('board/commemtreply/{tb_name}', [  //게시판 댓글에 답글 처리
    'as' => 'board.commemtreplysave',
    'uses' => 'App\Http\Controllers\board\BoardController@commemtreplysave',
]);

Route::post('board/commemtmodify/{tb_name}', [  //게시판 댓글 수정 처리
    'as' => 'board.commemtmodifysave',
    'uses' => 'App\Http\Controllers\board\BoardController@commemtmodifysave',
]);

Route::post('board/commemtdelete/{tb_name}', [  //게시판 댓글 삭제 처리
    'as' => 'board.commemtdelete',
    'uses' => 'App\Http\Controllers\board\BoardController@commemtdelete',
]);



/*** 프론트 메뉴 관리 */
//일반 페이지(html) 처리
//Route::get('/defalut_html/{pg_name}/{pg_code}', [
Route::get('/defalut_html/{pg_name}', [
    'as' => 'defalut.index',
    'uses' => 'App\Http\Controllers\defalut\Defalut_htmlController@index',
]);

//상품 페이지 일때 처리
Route::get('/item/item_page', [
    'as' => 'item.index',
    'uses' => 'App\Http\Controllers\item\ItemController@index',
]);


/*** 소셜 로그인 관련 ***/
Route::get('social/{provider}', [
    'as' => 'social.login',
    'uses' => 'App\Http\Controllers\auth\socialLoginController@redirect',
]);

Route::get('social/callback/{provider}', [
    'uses' => 'App\Http\Controllers\auth\socialLoginController@callback',
]);


/*** 관리자 페이지 접근 ***/
//route에서 관리자 분리
//app/Providers/RouteServiceProvider.php    //설정
//app/Http/Kernel.php   //설정
Route::prefix('adm')->group(base_path('routes/adm.php'));

/*** 관리자 페이지 쇼핑몰 접근 ***/
Route::prefix('adm/shop')->group(base_path('routes/shop.php'));




