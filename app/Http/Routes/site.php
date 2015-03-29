<?php

Route::group(['namespace'=>'Site'],function(){
	//Route::resource('category','Api\CategoryController');
	Route::get('/','HomeController@index');
});