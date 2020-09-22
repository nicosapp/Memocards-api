<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\Auth\CheckAccountEmail;
use App\Notifications\Mail\ApiVerifyEmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Auth::routes([
    'verify' => true
]);


Route::get('auth/token', function(Request $request){
    $verif = $request->user()->verification;
    dd($verif);
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function(){
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
    Route::post('signup', 'SignUpController');

    Route::get('email/verify/{numbers}', 'ApiVerificationController@verify')->name('verificationapi.verify');
    Route::get('email/resend', 'ApiVerificationController@resend')->name('verificationapi.resend');

    Route::patch('me', 'MeController@update');
    Route::get('me', 'MeController');
    Route::post('me/avatar', 'MeController@avatar');
});

Route::group(['prefix'=>'posts', 'namespace'=>'Posts'],function(){
    Route::get('','PostController@index');
});

Route::group(['prefix'=>'media', 'namespace'=>'Media'],function(){
    Route::get('types', 'MediaTypesController@index');
    // Route::post('', 'MediaController@store');
});


Route::group(['middleware'=>'auth:api','prefix'=>'me', 'namespace'=>'Me'],function(){
    Route::get('posts','PostController@index');
    Route::post('posts','PostController@store');
    Route::get('posts/{post}','PostController@show');
    Route::patch('posts/{post}','PostController@update');
    Route::delete('posts/{post}','PostController@destroy');

    Route::get('categories','CategoryController@index');
    Route::post('categories','CategoryController@store');
    Route::get('categories/{category}','CategoryController@show');
    Route::patch('categories/{category}','CategoryController@update');
    Route::delete('categories/{category}','CategoryController@destroy');
    Route::post('categories/{category}/link/{post}','CategoryController@link');
    Route::post('categories/{category}/unlink/{post}','CategoryController@unlink');
    

    Route::get('tags','TagController@index');
    Route::post('tags','TagController@store');
    Route::get('tags/{tag}','TagController@show');
    Route::patch('tags/{tag}','TagController@update');
    Route::delete('tags/{tag}','TagController@destroy');
    Route::delete('tags/{tag}','TagController@destroy');
    Route::post('tags/{tag}/link/{post}','TagController@link');
    Route::post('tags/{tag}/unlink/{post}','TagController@unlink');
});


Route::get('/preview-email', function(Request $request){
    $user = User::find(15);
    // dd($user->verification()->exists());
    // // dd($request->user()->id);
    // return new CheckEmail($user) //check le mail
    // Mail::to('cazi.nicolas@gmail.com')->send(new CheckAccountEmail($user)); //envoi le mail
    return (new ApiVerifyEmailNotification())->toMail($user);
});
