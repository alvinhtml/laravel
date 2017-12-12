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




Route::get('/', 'HomeController@index');
Route::get('/{urls}', 'HomeController@index')->where('urls','(?!api/).+');

Route::group(['middleware' => 'web', 'prefix' => 'api'], function () {

    Route::get("test", 'testController@index');

    //admins register
    Route::get('admin/register', 'Admin\AuthController@showRegistrationForm')->name('admin.register');
    Route::post('admin/register', 'Admin\AuthController@register');

    //admins login
    Route::get('admin/login', 'Admin\AuthController@showLoginForm')->name('admin.login');
	Route::post('admin/login', 'Admin\AuthController@login');

    //admins logout
	Route::get('admin/logout', 'Admin\AuthController@logout')->name("admin.logout");


    //Admins list
    Route::get('admin', 'Admin\AdminController@showAdminList');
    Route::get('admin/list', 'Admin\AdminController@showAdminList');
    Route::get('admin/add', 'Admin\AdminController@add');

    //logined info
    Route::get('authinfo', 'Admin\AdminController@authInfo')->name("authinfo");
    //Route::auth();


    Route::group(['prefix' => 'setting'], function () {
        Route::post('list_configs', 'SettingController@list_configs');
    });


});
