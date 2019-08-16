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

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//page 1 route
Route::get('page-1', 'Page1Controller@index')->name('page.1');
Route::get('ajax-people-db', 'AjaxController@people_db')->name('ajax-people-db');
Route::get('ajax-film-db', 'AjaxController@film_db')->name('ajax-film-db');

Route::post('get-film-via-api', 'Page1Controller@get_film')->name('get-film');
Route::post('get-people-via-api', 'Page1Controller@get_people')->name('get-people');

Route::post('save-film-to-db', 'Page1Controller@save_film')->name('save-film');
Route::post('save-people-to-db', 'Page1Controller@save_people')->name('save-people');

//page 2 route
Route::get('page-2', 'Page2Controller@index')->name('page.2');
Route::get('ajax-people-api', 'AjaxController@people_api')->name('ajax-people-api');
Route::get('ajax-film-api', 'AjaxController@film_api')->name('ajax-film-api');
Route::get('people-internal/{number}', 'Page2Controller@people_internal')
	->name('people-internal');
Route::get('film-internal/{number}', 'Page2Controller@film_internal')
	->name('film-internal');
