<?php
Route::group(['prefix' => 'api/v1','namespace'=>'Api','middleware'=>'api.token'],function(){
	//Route::resource('category','Api\CategoryController');
	Route::get('category/{q}/{start?}/{limit?}/{orderby?}','CategoryController@find');
	Route::put('category/{id}','CategoryController@update');
});