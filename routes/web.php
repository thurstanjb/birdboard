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

Route::group(['prefix' => '/projects', 'as' => 'projects.', 'middleware' => 'auth'], function(){
    Route::get('/', 'ProjectsController@index')->name('index');
    Route::get('/create', 'ProjectsController@create')->name('create');
    Route::get('/{project}', 'ProjectsController@show')->name('show');
    Route::post('/', 'ProjectsController@store')->name('store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
