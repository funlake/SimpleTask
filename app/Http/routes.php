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
#
#----Common pages routing sets-------#
#
// Route::get('/', 'WelcomeController@index');

// Route::get('home', 'HomeController@index');

// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);

//Route::put('home','WelcomeController@index');


#----Api routing sets---------------#
include __DIR__."/Routes/site.php";
include __DIR__."/Routes/admin.php";
include __DIR__."/Routes/rest.php";
