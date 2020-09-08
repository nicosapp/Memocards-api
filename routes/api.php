<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function(){
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
    Route::get('me', 'MeController');
});

Route::group(['prefix'=>'posts', 'namespace'=>'Posts'],function(){
    Route::get('','PostController@index');
    Route::post('','PostController@store');
    Route::get('{post}','PostController@show');
    Route::patch('{post}','PostController@update');
    Route::delete('{post}','PostController@destroy');
});

Route::group(['prefix'=>'me', 'namespace'=>'Me'],function(){
    Route::get('posts','PostController@index');
});

// Test
Route::group(['prefix' => 'test', 'namespace' => 'Test'], function(){
    Route::get('simple', 'TestController');
    Route::get('action', 'TestController@someAction');
});