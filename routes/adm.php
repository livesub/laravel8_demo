<?php

use Illuminate\Support\Facades\Route;


/*
Route::get('/', function () {
    dd(Auth::user());
});
*/

Route::get('/', [
    'as' => 'adm.index',
    'uses' => 'App\Http\Controllers\adm\AdmController@index',
]);

Route::get('login', [
    'as' => 'adm.login.index',
    'uses' => 'App\Http\Controllers\adm\AdmloginController@index',
]);

Route::post('login', [
    'as' => 'adm.login.store',
    'uses' => 'App\Http\Controllers\adm\AdmloginController@store',
]);

/* 로그인 사용자만 볼수 있는 페이지를 group 로 묶는다(관리자) */
//Route::group(['middleware' => ['auth']], function () {
Route::group(['middleware' => 'is.admin'], function () {    //미들웨어로 만들어서 관리자 가 아니먄 튕기게 한다
    /* 회원 리스트 */
    Route::get('member', [
        'as' => 'adm.member.index',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@index',
    ]);

    /* 회원 등록 */
    Route::get('member/member_regi', [  //등록,수정 같이 씀
        'as' => 'adm.member.show',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@show',
    ]);

    Route::post('member/member_regi', [ //등록,수정 처리
        'as' => 'adm.member.regi.store',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@store',
    ]);


    Route::post('member/member_pw_change', [    //비번변경
        'as' => 'adm.member.pw_change',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@pw_change',
    ]);

    Route::post('member/member_img_del', [    //이미지 삭제
        'as' => 'adm.member.imgdel',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@imgdel',
    ]);

    Route::post('member/member_out', [    //회원 탈퇴
        'as' => 'adm.member.out',
        'uses' => 'App\Http\Controllers\adm\member\MemberlistController@member_out',
    ]);
/*** 관리자 회원 관련 끝 */



/*** 관리자 게시판 관리 */
    Route::get('boardmanage', [     //리스트
        'as' => 'adm.boardmanage.index',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@index',
    ]);

    Route::post('boardmanage/boardadd', [   //게시판 생성
        'as' => 'adm.boardmanage.create',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@create',
    ]);

    Route::post('boardmanage/boardshow', [   //게시판 설정 view
        'as' => 'adm.boardmanage.show',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@show',
    ]);

    Route::post('boardmanage/boardstore', [   //게시판 설정 저장
        'as' => 'adm.boardmanage.store',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@store',
    ]);

    Route::post('boardmanage/boarddel', [   //게시판 삭제
        'as' => 'adm.boardmanage.destroy',
        'uses' => 'App\Http\Controllers\adm\boardmanage\BoardmanageController@destroy',
    ]);

    Route::get('admboard/list/{tb_name}', [  //게시판 리스트
        'as' => 'adm.admboard.index',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@index',
    ]);

    Route::post('admboard/list/choice_del', [  //게시판 리스트 에서 관리자 선택 삭제
        'as' => 'adm.admboard.choice_del',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@choice_del',
    ]);

    Route::get('admboard/write/{tb_name}', [  //게시판 글쓰기
        'as' => 'adm.admboard.create',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@create',
    ]);

    Route::post('admboard/write/', [  //게시판 글쓰기 저장
        'as' => 'adm.admboard.store',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@store',
    ]);

    Route::get('admboard/view/{tb_name}', [  //게시판 view
        'as' => 'adm.admboard.show',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@show',
    ]);

    Route::get('admboard/secret/{tb_name}', [  //게시판 비밀글 처리
        'as' => 'adm.admboard.secret',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@secret',
    ]);

    Route::post('admboard/secretpw/', [  //게시판 비밀글 처리
        'as' => 'adm.admboard.secretpw',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@secretpw',
    ]);

    Route::post('admboard/downloadfile/', [  //게시판 첨부파일 다운로드 처리
        'as' => 'adm.admboard.downloadfile',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@downloadfile',
    ]);

    Route::get('admboard/reply/{tb_name}/{ori_num}', [  //게시판 답글 쓰기
        'as' => 'adm.admboard.reply',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@reply',
    ]);

    Route::post('admboard/replysave/{tb_name}', [  //게시판 답글 저장
        'as' => 'adm.admboard.replysave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@replysave',
    ]);

    Route::get('admboard/modify/{tb_name}/{ori_num}', [  //게시판 수정
        'as' => 'adm.admboard.modify',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@modify',
    ]);

    Route::post('admboard/modifysave/{tb_name}', [  //게시판 수정 저장
        'as' => 'adm.admboard.modifysave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@modifysave',
    ]);

    Route::post('admboard/delete/{tb_name}', [  //게시판 삭제 처리
        'as' => 'adm.admboard.deletesave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@deletesave',
    ]);

    Route::post('admboard/commemt/{tb_name}', [  //게시판 댓글 처리
        'as' => 'adm.admboard.commentsave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@commentsave',
    ]);

    Route::post('admboard/commemtreply/{tb_name}', [  //게시판 댓글에 답글 처리
        'as' => 'adm.admboard.commemtreplysave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@commemtreplysave',
    ]);

    Route::post('admboard/commemtmodify/{tb_name}', [  //게시판 댓글 수정 처리
        'as' => 'adm.admboard.commemtmodifysave',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@commemtmodifysave',
    ]);

    Route::post('admboard/commemtdelete/{tb_name}', [  //게시판 댓글 삭제 처리
        'as' => 'adm.admboard.commemtdelete',
        'uses' => 'App\Http\Controllers\adm\admboard\AdmboardController@commemtdelete',
    ]);

    Route::get('editor', [  //스마트 에디터를 통해 남아 있는 불필요 파일 제거
        'as' => 'adm.editor.delete',
        'uses' => 'App\Http\Controllers\adm\editor\AdmeditorController@destroy',
    ]);

/*** 관리자 카테고리 관리 */
    Route::get('cate', [       //카테고리 리스트
        'as' => 'adm.cate.index',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateController@index',
    ]);

    Route::get('catecreate', [      //1단계 카테고리 등록 페이지
        'as' => 'adm.cate.catecreate',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateController@catecreate',
    ]);

    Route::post('catecreatesave', [     //1단계 카테고리 등록
        'as' => 'adm.cate.catecreatesave',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateController@catecreatesave',
    ]);

    Route::post('cate_add', [       //카테고리 추가 페이지
        'as' => 'adm.cate.cate_add',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateController@cate_add',
    ]);

    Route::post('cate_add_save', [      //카테고리 추가
        'as' => 'adm.cate.cate_add_save',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateConrtoller@cate_add_save',
    ]);

    Route::post('cate_modi', [      //카테고리 수정
        'as' => 'adm.cate.cate_modi',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateController@cate_modi',
    ]);

    Route::post('cate_modi_save', [     //카테고리 등록
        'as' => 'adm.cate.cate_modi_save',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateController@cate_modi_save',
    ]);

    Route::post('cate_delete', [    //카테고리 삭제
        'as' => 'adm.cate.cate_delete',
        'uses' => 'App\Http\Controllers\adm\cate\AdmcateController@cate_delete',
    ]);

/*** 관리자 상품 관리 */
    Route::get('itemlist', [        //상품 리스트
        'as' => 'adm.item.index',
        'uses' => 'App\Http\Controllers\adm\item\AdmitemController@index',
    ]);

    Route::get('itemcreate', [      //상품 등록 페이지
        'as' => 'adm.item.create',
        'uses' => 'App\Http\Controllers\adm\item\AdmitemController@create',
    ]);

    Route::post('itemselect', [     //상품 카테고리 ajax
        'as' => 'adm.cate.ajax_select',
        'uses' => 'App\Http\Controllers\adm\item\AdmitemController@ajax_select',
    ]);

    Route::post('itemcreate', [     //상품 선택 등록
        'as' => 'adm.item.createsave',
        'uses' => 'App\Http\Controllers\adm\item\AdmitemController@createsave',
    ]);

    Route::post('itemchoice_del', [  //상품 선택 삭제
        'as' => 'adm.item.choice_del',
        'uses' => 'App\Http\Controllers\adm\item\AdmitemController@choice_del',
    ]);

    Route::get('itemmodify', [  //상품 수정 페이지
        'as' => 'adm.item.modify',
        'uses' => 'App\Http\Controllers\adm\item\AdmitemController@modify',
    ]);

    Route::post('itemdownloadfile', [  //상품 이미지 다운로드
        'as' => 'adm.item.downloadfile',
        'uses' => 'App\Http\Controllers\adm\item\AdmitemController@downloadfile',
    ]);

    Route::post('itemmodifysave', [  //상품 수정 등록
        'as' => 'adm.item.modifysave',
        'uses' => 'App\Http\Controllers\adm\item\AdmitemController@modifysave',
    ]);

/*** 관리자 메뉴 관리 */
    Route::get('menu', [       //메뉴 카테고리 리스트
        'as' => 'adm.menu.index',
        'uses' => 'App\Http\Controllers\adm\menu\AdmmenuController@index',
    ]);

    Route::get('menucreate', [      //1단계 메뉴 카테고리 등록 페이지
        'as' => 'adm.menu.create',
        'uses' => 'App\Http\Controllers\adm\menu\AdmmenuController@create',
    ]);

    Route::post('menucreate', [      //1단계 메뉴 카테고리 저장 처리
        'as' => 'adm.menu.createsave',
        'uses' => 'App\Http\Controllers\adm\menu\AdmmenuController@createsave',
    ]);

    Route::get('menu_add', [       //메뉴 카테고리 추가 페이지
        'as' => 'adm.menu.menu_add',
        'uses' => 'App\Http\Controllers\adm\menu\AdmmenuController@menu_add',
    ]);

    Route::post('menu_add_save', [      //메뉴 카테고리 추가 처리
        'as' => 'adm.menu.menu_add_save',
        'uses' => 'App\Http\Controllers\adm\menu\AdmmenuController@menu_add_save',
    ]);

    Route::get('menu_modi', [      //메뉴 카테고리 수정
        'as' => 'adm.menu.menu_modi',
        'uses' => 'App\Http\Controllers\adm\menu\AdmmenuController@menu_modi',
    ]);

    Route::post('menu_modi_save', [     //메뉴 카테고리 수정 처리
        'as' => 'adm.menu.modi_save',
        'uses' => 'App\Http\Controllers\adm\menu\AdmmenuController@modi_save',
    ]);

    Route::post('menu_delete', [    //메뉴 카테고리 삭제
        'as' => 'adm.menu.delete',
        'uses' => 'App\Http\Controllers\adm\menu\AdmmenuController@delete_save',
    ]);

/*** 관리자 이메일 발송 관리 */
    Route::get('admemail', [    //회원 이메일 리스트
        'as' => 'adm.admemail.index',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@index',
    ]);

    Route::get('admemail_create', [    //회원 이메일 내용 추가
        'as' => 'adm.admemail.create',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@create',
    ]);

    Route::post('admemail_create', [    //회원 이메일 내용 추가
        'as' => 'adm.admemail.createsave',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@createsave',
    ]);

    Route::post('admemail_choice_del', [    //이메일 선택 삭제
        'as' => 'adm.admemail.choice_del',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@choice_del',
    ]);

    Route::get('admemail_send_mem_chk', [    //이메일 보내기 (회원 선택 화면)
        'as' => 'adm.admemail.send_mem_chk',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@send_mem_chk',
    ]);

    Route::post('admemail_send_ok', [    //이메일 발송
        'as' => 'adm.admemail.send_ok',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@send_ok',
    ]);

    Route::get('admemail_modify', [    //회원 이메일 내용 수정
        'as' => 'adm.admemail.modify',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@modify',
    ]);

    Route::post('admemail_modifysave', [    //회원 이메일 내용 수정 저장
        'as' => 'adm.admemail.modifysave',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@modifysave',
    ]);

    Route::post('admemail_downloadfile/', [  //회원 이메일 첨부파일 다운로드 처리
        'as' => 'adm.admemail.downloadfile',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@downloadfile',
    ]);

    Route::get('admemail_sendlist/', [  //회원 이메일 첨부파일 다운로드 처리
        'as' => 'adm.admemail.sendlist',
        'uses' => 'App\Http\Controllers\adm\admemail\AdmemailController@sendlist',
    ]);

/*** 관리자 통계 관리 */
    Route::get('visitslist/', [  //방문자 통계 리스트
        'as' => 'adm.visit.index',
        'uses' => 'App\Http\Controllers\adm\visits\VisitsController@index',
    ]);

    Route::get('membervisitslist/', [  //회원 로그인 통계 리스트
        'as' => 'adm.visit.memberindex',
        'uses' => 'App\Http\Controllers\adm\visits\VisitsController@memberindex',
    ]);

/*** 관리자 팝업 관리 */
    Route::get('popuplist/', [  //팝업 리스트
        'as' => 'adm.popup.index',
        'uses' => 'App\Http\Controllers\adm\popup\PopupController@index',
    ]);

    Route::get('popupcreate', [  //팝업 등록 폼
        'as' => 'adm.pop.create',
        'uses' => 'App\Http\Controllers\adm\popup\PopupController@create',
    ]);

    Route::post('popupcreate', [  //팝업 저장
        'as' => 'adm.pop.createsave',
        'uses' => 'App\Http\Controllers\adm\popup\PopupController@createsave',
    ]);

    Route::post('popupmodify', [  //팝업 수정 폼
        'as' => 'adm.pop.modify',
        'uses' => 'App\Http\Controllers\adm\popup\PopupController@modify',
    ]);

    Route::post('popupmodifysave', [  //팝업 수정 처리
        'as' => 'adm.pop.modifysave',
        'uses' => 'App\Http\Controllers\adm\popup\PopupController@modifysave',
    ]);

    Route::post('popupdestroy', [  //팝업 삭제 처리
        'as' => 'adm.pop.destroy',
        'uses' => 'App\Http\Controllers\adm\popup\PopupController@destroy',
    ]);
});