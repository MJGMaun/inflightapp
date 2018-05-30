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

Route::resource('movies', 'MoviesController');
Route::resource('admin/movies', 'Admin\MoviesController');
Auth::routes();
Route::get('/user/home', 'HomeController@index')->name('home');

Route::get('/admin/home', 'HomeController@someAdminStuff')->name('home');
