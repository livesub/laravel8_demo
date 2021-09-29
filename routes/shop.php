<?php

use Illuminate\Support\Facades\Route;


/** 쇼핑몰 프론트 **/
/*
Route::get('/', function () {
    dd(Auth::user());
});
*/

Route::get('/', [
    'as' => 'index',
    'uses' => 'App\Http\Controllers\shop\ShopMainController@index',
]);

//상품 리스트 페이지 처리
Route::get('/sitem', [
    'as' => 'sitem',
    'uses' => 'App\Http\Controllers\shop\ItemController@index',
]);

//상품 리스트 페이지 처리
Route::get('/sitemdetail', [
    'as' => 'sitemdetail',
    'uses' => 'App\Http\Controllers\shop\ItemController@sitemdetail',
]);

//상품 리스트 페이지 이미지 변환 처리
Route::get('/sitemdetail_img', [
    'as' => 'ajax_big_img_change',
    'uses' => 'App\Http\Controllers\shop\ItemController@ajax_big_img_change',
]);

//상품 리스트 선택 옵션 처리
Route::get('/sitemdetail_option', [
    'as' => 'ajax_option_change',
    'uses' => 'App\Http\Controllers\shop\ItemController@ajax_option_change',
]);

//장바구니, 바로구매 처리
Route::post('/cart', [
    'as' => 'ajax_cart_register',
    'uses' => 'App\Http\Controllers\shop\CartController@ajax_cart_register',
]);