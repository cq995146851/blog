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


/******************************静态页*********************************/
Route::get('/', 'ArticlesController@index')->name('articles.index');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

/********************************用户*****************************************/
Route::resource('/users', 'UsersController');
//注册邮箱激活
Route::get('/user/confirm_create/{token}', 'UsersController@confirmCreate')->name('confirmUserCreate');
//修改密码
Route::get('/users/reset_password/create', 'UsersController@createResetPassword')->name('users.reset_password');
Route::post('/users/reset_password/store', 'UsersController@storeResetPassword')->name('users.save_reset_password');


/******************************会话控制*****************************************/
Route::resource('/sessions', 'SessionsController')->only([
    'create', 'store', 'destroy'
]);


/*********************************找回密码*************************************/
Route::resource('/password', 'PasswordController')->only([
    'create', 'store'
]);

//密码找回确认
Route::get('/password/confirm_reset_password/{token}/{email}', 'PasswordController@confirmResetPassword')->name('confirmResetPassword');
Route::post('/password/save', 'PasswordController@save')->name('password.save');

/***********************************文章*******************************************/
Route::resource('/articles', 'ArticlesController');
//上传图片
Route::post('/articles/upload_img', 'ArticlesController@uploadImg')->name('articles.upload_img');


