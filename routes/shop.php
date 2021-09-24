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