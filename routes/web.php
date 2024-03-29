<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/redirect', 'SocialAuthFacebookController@redirect');
// Route::get('/callback', 'SocialAuthFacebookController@callback');
Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');
Route::get('/login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');



Route::get('/googleredirect', 'SocialAuthGoogleController@redirect');
Route::get('/googlecallback', 'SocialAuthGoogleController@callback');

Route::get('/home', 'HomeController@index')->name('home');
