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
//MOVIES
Route::resource('movies', 'MoviesController');
Route::resource('admin/movies', 'Admin\MoviesController');
//MUSIC
Route::get('admin/musics/{id}/createWId', 'Admin\MusicsController@createWId')->name('musics.createWId');
Route::get('admin/musics/{id}/createAlbumWId', 'Admin\MusicsController@createAlbumWId')->name('musics.createAlbumWId');
Route::get('admin/musics/createArtist', 'Admin\MusicsController@createArtist')->name('musics.createArtist');
Route::post('admin/musics/storeArtist', 'Admin\MusicsController@storeArtist')->name('musics.storeArtist');
Route::get('admin/musics/{id}/editArtist', 'Admin\MusicsController@editArtist')->name('musics.editArtist');
Route::put('admin/musics/{id}/updateArtist', 'Admin\MusicsController@updateArtist')->name('musics.updateArtist');
Route::delete('admin/musics/{id}/destroyArtist', 'Admin\MusicsController@destroyArtist')->name('musics.destroyArtist');

Route::get('admin/musics/{id}/editAlbum', 'Admin\MusicsController@editAlbum')->name('musics.editAlbum');
Route::put('admin/musics/{id}/updateAlbum', 'Admin\MusicsController@updateAlbum')->name('musics.updateAlbum');
Route::delete('admin/musics/{id}/destroyAlbum', 'Admin\MusicsController@destroyAlbum')->name('musics.destroyAlbum');

Route::get('admin/musics/createByAlbum', 'Admin\MusicsController@createByAlbum')->name('musics.createByAlbum');
Route::get('/json_albums','Admin\MusicsController@json_albums');
Route::resource('admin/musics', 'Admin\MusicsController');

Auth::routes();
Route::get('/user/home', 'HomeController@index')->name('home');

Route::get('/admin/home', 'HomeController@someAdminStuff')->name('home');

Auth::routes();
Route::get('/user/home', 'HomeController@index')->name('home');

Route::get('/admin/home', 'HomeController@someAdminStuff')->name('home');
