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

//Route::resource('/', 'MushafController');
//Route::post('save','MushafController@setLinePage');
Route::get('/',  ['as' => 'Home', 'uses' => 'MushafController@index']);
Route::get('getPage','MushafController@getPage');
Route::get('app','AppController@index');
Route::get('turne','AppController@turne');
Route::get('allFehras','AppController@allFehras');
Route::get('allJuz','AppController@allJuz');
Route::get('goAya','AppController@goAya');
Route::get('goAyaPage','AppController@goAyaPage');

Route::get('search','AppController@search');
Route::get('saveHTML','AppController@saveHTML');
//Route::get('/', function(){
//	return view('index'); 
//});