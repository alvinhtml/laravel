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
    return view('index');
});

Route::get('/{urls}', function () {
    return view('index');
})->where('urls','(?!api/).+');

Route::group(['middleware' => 'web', 'prefix' => 'api'], function () {

    Route::get("test", 'testController@index');

    Route::get('admin/register', 'Admin\AuthController@showRegistrationForm')->name('admin.register');
    Route::post('admin/register', 'Admin\AuthController@register');
    //Route::post('admin/register', 'Admin\RegisterController@register');

    Route::get('admin/login', 'Admin\AuthController@showLoginForm')->name('admin.login');
	Route::post('admin/login', 'Admin\AuthController@login');
	Route::get('admin/logout', 'Admin\AuthController@logout')->name("admin.logout");



    //Route::auth();
    //Route::get('home', 'HomeController@index');

	/*Route::get('admin/login', 'Admin\AuthController@getLogin');
    Route::post('admin/login', 'Admin\AuthController@postLogin');
    Route::get('admin/register', 'Admin\AuthController@getRegister');
    Route::post('admin/register', 'Admin\AuthController@postRegister');*/
    Route::get('admin', 'AdminController@index');


    //Admin Authentication Routes...
    /*Route::get('admin/login', 'Admin\LoginController@showLoginForm')->name('login');
    Route::post('admin/login', 'Admin\LoginController@login');
    Route::post('admin/logout', 'Admin\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('admin/register', 'Admin\RegisterController@showRegistrationForm')->name('register');
    Route::post('admin/register', 'Admin\RegisterController@register');*/




});
