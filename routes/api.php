<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use App\Mail\Auth\CheckAccountEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Notifications\Mail\ApiVerifyEmailNotification;


Auth::routes([
  'verify' => true
]);

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
  Route::post('signin', 'SignInController');
  Route::post('signout', 'SignOutController');
  Route::post('signup', 'SignUpController');

  Route::get('email/verify/{numbers}', 'ApiVerificationController@verify')->name('verificationapi.verify');
  Route::get('email/resend', 'ApiVerificationController@resend')->name('verificationapi.resend');

  Route::patch('me', 'MeController@update');
  Route::get('me', 'MeController');
  Route::post('me/avatar', 'MeController@avatar');
});

Route::group(['prefix' => 'posts', 'namespace' => 'Posts'], function () {
  Route::get('', 'PostController@index');
});

Route::group(['prefix' => 'media', 'namespace' => 'Media'], function () {
  Route::get('types', 'MediaTypesController@index');
  // Route::post('', 'MediaController@store');
});


Route::group(['middleware' => 'auth:api', 'prefix' => 'me', 'namespace' => 'Me'], function () {
  Route::get('posts', 'PostController@index');
  Route::post('posts', 'PostController@store');
  Route::get('posts/{post}', 'PostController@show');
  Route::patch('posts/{post}', 'PostController@update');
  Route::delete('posts/{post}', 'PostController@destroy');

  Route::post('medias', 'MediaController@store');
  Route::get('medias/{media}', 'MediaController@show');
  Route::get('medias', 'MediaController@index');
  Route::patch('medias/{media}', 'MediaController@update');
  Route::delete('medias/{media}', 'MediaController@destroy');


  Route::get('dashboard/lastCreated', 'PostDashboardController@lastCreated');
  Route::get('dashboard/favorites', 'PostDashboardController@favorites');
  Route::get('dashboard/mostViewed', 'PostDashboardController@mostViewed');

  Route::get('categories', 'CategoryController@index');
  Route::post('categories', 'CategoryController@store');
  Route::get('categories/{category}', 'CategoryController@show');
  Route::patch('categories/{category}', 'CategoryController@update');
  Route::patch('categoriesBulk', 'CategoryController@updateBulk');
  Route::delete('categories/{category}', 'CategoryController@destroy');
  Route::post('categories/{category}/link/{post}', 'CategoryController@link');
  Route::post('categories/{category}/unlink/{post}', 'CategoryController@unlink');


  Route::get('tags', 'TagController@index');
  Route::post('tags', 'TagController@store');
  Route::get('tags/{tag}', 'TagController@show');
  Route::patch('tags/{tag}', 'TagController@update');
  Route::delete('tags/{tag}', 'TagController@destroy');
  Route::delete('tags/{tag}', 'TagController@destroy');
  Route::post('tags/{tag}/link/{post}', 'TagController@link');
  Route::post('tags/{tag}/unlink/{post}', 'TagController@unlink');
});


Route::get('/email', function (Request $request) {
  // $user = User::find(1);
  $user = $request->user();
  // dd($user->verification()->exists());
  // // dd($request->user()->id);
  // return new CheckEmail($user) //check le mail
  // Mail::to('cazi.nicolas@gmail.com')->send(new CheckAccountEmail($user)); //envoi le mail
  // App::setLocale('fr');
  return (new ApiVerifyEmailNotification())->toMail($user);
})->middleware('auth:api');
