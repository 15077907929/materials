<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware'=>['web']],function(){
	Route::get('/','Home\IndexController@index');
	
	Route::get('/cate/{id}','Home\CategoryController@cate');
	Route::get('/arts/{id}','Home\CategoryController@arts');
	Route::get('/art/{id}','Home\ArticleController@art');
	
	
	Route::get('/art','Home\IndexController@article');
	
	
	Route::get('/conc','Home\IndexController@contact');
});

Route::any('admin/login','Admin\LoginController@login');
Route::get('admin/code','Admin\LoginController@code');
Route::any('admin/upload','Admin\CommonController@upload');


Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
	Route::get('index','IndexController@index');
	Route::get('sys_info','IndexController@sys_info');
	
	Route::get('common/top','CommonController@top');
	Route::get('common/left','CommonController@left');
	Route::get('common/left_switch','CommonController@left_switch');
	Route::get('common/bottom','CommonController@bottom');
	
	Route::any('basic_set/password','Basic_setController@password');
	Route::post('basic_set/category/change_order','Basic_setController@change_order');
	Route::resource('basic_set/category','CategoryController');
	
	Route::post('article/change_order','ArticleController@change_order');
	Route::resource('article','ArticleController');
	
	
	Route::resource('links','LinksController');
	Route::post('links/change_order','LinksController@change_order');	
	
	Route::resource('navs','NavsController');
	Route::post('navs/change_order','NavsController@change_order');	
	
	Route::get('config/put_file','ConfigController@put_file');
	Route::resource('config','ConfigController');
	Route::post('config/change_order','ConfigController@change_order');
	Route::post('config/change_content','ConfigController@change_content');
	
	Route::get('logout','LoginController@logout');
});






