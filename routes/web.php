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
Route::get('/',function (){
    return view("index/index");
});


Route::get('test',  "TestController@index");



Route::get('login',function (){
    return view("login.login");
});


Route::post('articles','ArticleController@articleFile');

Route::get('categorys/index',  "CategoryController@index");

Route::get('tags/index', "TagController@index");

Route::post('tags', "TagController@store");

Route::post('categorys', "CategoryController@store");

Route::put("categorys", "CategoryController@update");

Route::put("tags","TagController@update");

Route::get("categorys","CategoryController@get");

Route::get("tags","TagController@get");

Route::delete("categorys","CategoryController@drop");


Route::get('articles/index', "ArticleController@index");



Route::post('articles',"ArticleController@store");

Route::put("articles","ArticleController@update");

Route::get("articles","ArticleController@get");

Route::delete("articles","ArticleController@destroy");

Route::delete("tags","TagController@destroy");

