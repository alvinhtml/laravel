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

Route::get('api/test', 'testController@index');

//admins register
Route::get('api/admin/register', 'Admin\AuthController@showRegistrationForm')->name('admin.register');
Route::post('api/admin/register', 'Admin\AuthController@register');

//admins login
Route::get('api/admin/login', 'Admin\AuthController@showLoginForm')->name('admin.login');
Route::post('api/admin/login', 'Admin\AuthController@login');

//admins logout
Route::get('api/admin/logout', 'Admin\AuthController@logout')->name("admin.logout");


//Admins list
Route::get('api/admin', 'Admin\AdminController@showAdminList');
Route::get('api/admin/list', 'Admin\AdminController@showAdminList');
Route::post('api/admin/edit/{id?}', 'Admin\AdminController@add');
Route::get('api/admin/view/{id}', 'Admin\AdminController@view');
Route::get('api/admin/del/{id}', 'Admin\AdminController@del');
Route::get('api/admin/edit_state/{id}', 'Admin\AdminController@edit_state');

//term list
Route::get('api/term', 'TermController@showTermList');
Route::get('api/term/list', 'TermController@showTermList');
Route::post('api/term/edit/{id?}', 'TermController@add');
Route::get('api/term/view/{id}', 'TermController@view');
Route::get('api/term/del/{id}', 'TermController@del');
// Route::get('api/term/edit_state/{id}', 'TermController@edit_state');

//ou list
Route::get('api/ou', 'OuController@showOuList');
Route::get('api/ou/list', 'OuController@showOuList');
Route::post('api/ou/edit/{id?}', 'OuController@add');
Route::get('api/ou/view/{id}', 'OuController@view');
Route::get('api/ou/del/{id}', 'OuController@del');
Route::get('api/ou/component', 'OuController@componentlist');
// Route::get('api/ou/edit_state/{id}', 'OuController@edit_state');

//logined info
Route::get('api/authinfo', 'Admin\AdminController@authInfo')->name("authinfo");
//Route::auth();

//setting
Route::post('api/setting/list_configs', 'SettingController@list_configs');
