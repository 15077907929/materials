<?php

Route::any('admin/login','Admin\LoginController@login');
Route::get('admin/code','Admin\LoginController@code');


Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
	Route::get('index','IndexController@index');
	
	//网站栏目
	Route::resource('cate','CategoryController');
	
	Route::get('logout','LoginController@logout');
	
});

?>




