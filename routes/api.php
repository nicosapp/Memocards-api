<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function(){
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
    Route::get('me', 'MeController');
});
Route::group(['prefix' => 'test', 'namespace' => 'Test'], function(){
    Route::get('simple', 'TestController');
});