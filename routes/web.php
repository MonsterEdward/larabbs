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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'PagesController@root')->name('root');
//Auth::routes(); //为什么Auth::routes()就等同于这么多条路由?
/*
https://laravel-china.org/topics/9469/excuse-me-auth-routes-where-do-you-find-the-routes-that-are-extended-in-which-document-is-it-in
*/
//等同于
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//resourse
//等同于
/*
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::patch('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::get('/users/{user}', 'UsersController@update')->name('users.update');
*/
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

// laravel隐形路由绑定, https://laravel-china.org/docs/laravel/5.5/routing/1293#%E9%9A%90%E5%BC%8F%E7%BB%91%E5%AE%9A
//Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
// ?意味着参数可选
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show'); // 隐性路由绑定, https://laravel-china.org/docs/laravel/5.5/routing/1293#%E9%9A%90%E5%BC%8F%E7%BB%91%E5%AE%9A

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

// topic上传图片路由
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');