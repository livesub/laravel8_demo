<?php

use Illuminate\Support\Facades\Route;

//쇼핑몰 관련
/* 로그인 사용자만 볼수 있는 페이지를 group 로 묶는다(관리자) */
Route::group(['middleware' => 'is.admin'], function () {    //미들웨어로 만들어서 관리자 가 아니먄 튕기게 한다

    /*** 분류 관리 */
    Route::get('scate', [       //카테고리 리스트
        'as' => 'shop.cate.index',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@index',
    ]);

    Route::get('scate_create', [      //1단계 카테고리 등록 페이지
        'as' => 'shop.cate.create',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@catecreate',
    ]);

    Route::post('scate_createsave', [      //1단계 카테고리 등록 페이지
        'as' => 'shop.cate.createsave',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@createsave',
    ]);

    Route::post('scate_add', [       //카테고리 추가 페이지
        'as' => 'shop.cate.cate_add',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_add',
    ]);

    Route::post('scate_add_save', [      //카테고리 추가
        'as' => 'shop.cate.cate_add_save',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_add_save',
    ]);

    Route::post('scate_modi', [      //카테고리 수정
        'as' => 'shop.cate.cate_modi',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_modi',
    ]);

    Route::post('scate_modi_save', [     //카테고리 등록
        'as' => 'shop.cate.cate_modi_save',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_modi_save',
    ]);

    Route::post('scate_delete', [    //카테고리 삭제
        'as' => 'shop.cate.cate_delete',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_delete',
    ]);

/*** 상품 관리 */
    Route::get('item_list', [    //상품 관리 리스트
        'as' => 'shop.item.index',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@index',
    ]);

    Route::get('itemcreate', [      //상품 등록 페이지
        'as' => 'shop.item.create',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@create',
    ]);

    Route::post('itemselect', [     //상품 카테고리 ajax
        'as' => 'shop.cate.ajax_select',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@ajax_select',
    ]);

    Route::post('itemcreate', [     //상품 선택 등록
        'as' => 'shop.item.createsave',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@createsave',
    ]);
});