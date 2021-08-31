<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [
    'as' => 'shop.index',
    'uses' => 'App\Http\Controllers\adm\shop\AdmShopController@index',
]);