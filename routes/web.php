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


    //Admin
    Route::get('admin', 'Admin\AdminController@showAdminList');
    Route::get('admin/list', 'Admin\AdminController@showAdminList');



});
