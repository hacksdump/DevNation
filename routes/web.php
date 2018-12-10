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

Route::get('post/{id}', 'PostController@getPost');

Route::get('user/{username}', 'UserController@showProfile');

Route::get('login', 'Auth\LoginController@showLogin');
Route::post('login', 'Auth\LoginController@checkLogin');

Route::get('register', 'Auth\LoginController@showRegister');
Route::post('register', 'Auth\RegisterController@create');

Route::get('ask', 'PostController@showPostCreator');
Route::post('ask', 'PostController@createPost');

Route::get('logout', "Auth\LoginController@logout");

Route::post('answer', 'PostController@postAnswer');
Route::get('answer/{question}', 'PostController@getAllAnswers');

Route::post('upvote', 'PostController@upvoteAnswer');
