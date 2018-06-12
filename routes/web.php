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
Route::get('admin/musics/createArtist', 'Admin\MusicsController@createArtist')->name('musics.createArtist');
Route::post('admin/musics/storeArtist', 'Admin\MusicsController@storeArtist')->name('musics.storeArtist');
Route::get('admin/musics/createByAlbum', 'Admin\MusicsController@createByAlbum')->name('musics.createByAlbum');
Route::get('/json_albums','Admin\MusicsController@json_albums');
Route::resource('admin/musics', 'Admin\MusicsController');

Auth::routes();
Route::get('/user/home', 'HomeController@index')->name('home');

Route::get('/admin/home', 'HomeController@someAdminStuff')->name('home');

Auth::routes();
Route::get('/user/home', 'HomeController@index')->name('home');

Route::get('/admin/home', 'HomeController@someAdminStuff')->name('home');
