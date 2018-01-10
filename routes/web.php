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
    Route::post('admin/edit/{id?}', 'Admin\AdminController@add');
    Route::get('admin/view/{id}', 'Admin\AdminController@view');
    Route::get('admin/del/{id}', 'Admin\AdminController@del');
    Route::get('admin/edit_state/{id}', 'Admin\AdminController@edit_state');

    //term list
    Route::get('term', 'TermController@showTermList');
    Route::get('term/list', 'TermController@showTermList');
    Route::post('term/edit/{id?}', 'TermController@add');
    Route::get('term/view/{id}', 'TermController@view');
    Route::get('term/del/{id}', 'TermController@del');
    // Route::get('term/edit_state/{id}', 'TermController@edit_state');

    //ou list
    Route::get('ou', 'OuController@showOuList');
    Route::get('ou/list', 'OuController@showOuList');
    Route::post('ou/edit/{id?}', 'OuController@add');
    Route::get('ou/view/{id}', 'OuController@view');
    Route::get('ou/del/{id}', 'OuController@del');
    Route::get('ou/component', 'OuController@componentlist');
    // Route::get('ou/edit_state/{id}', 'OuController@edit_state');

    //logined info
    Route::get('authinfo', 'Admin\AdminController@authInfo')->name("authinfo");
    //Route::auth();


    Route::group(['prefix' => 'setting'], function () {
        Route::post('list_configs', 'SettingController@list_configs');
    });


});
