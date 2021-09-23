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

