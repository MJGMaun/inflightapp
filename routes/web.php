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

//SERIES
Route::get('admin/series/createSeason', 'Admin\SeriesController@createSeason')->name('musics.createSeason');
Route::post('admin/musics/storeSeason', 'Admin\SeriesController@storeSeason')->name('musics.storeSeason');
Route::get('/json_seasons','Admin\SeriesController@json_seasons');
Route::resource('admin/series', 'Admin\SeriesController');

//ADs
Route::resource('admin/ads', 'Admin\AdsController');

//MUSIC
Route::get('admin/musics/{id}/createWId', 'Admin\MusicsController@createWId')->name('musics.createWId');
Route::get('admin/musics/{id}/createAlbumWId', 'Admin\MusicsController@createAlbumWId')->name('musics.createAlbumWId');



//ARTIST
Route::get('admin/musics/createArtist', 'Admin\MusicsController@createArtist')->name('musics.createArtist');
Route::post('admin/musics/storeArtist', 'Admin\MusicsController@storeArtist')->name('musics.storeArtist');
Route::get('admin/musics/{id}/editArtist', 'Admin\MusicsController@editArtist')->name('musics.editArtist');
Route::put('admin/musics/{id}/updateArtist', 'Admin\MusicsController@updateArtist')->name('musics.updateArtist');
Route::delete('admin/musics/{id}/destroyArtist', 'Admin\MusicsController@destroyArtist')->name('musics.destroyArtist');
//ALBUM
Route::get('admin/musics/{id}/editAlbum', 'Admin\MusicsController@editAlbum')->name('musics.editAlbum');
Route::put('admin/musics/{id}/updateAlbum', 'Admin\MusicsController@updateAlbum')->name('musics.updateAlbum');
Route::delete('admin/musics/{id}/destroyAlbum', 'Admin\MusicsController@destroyAlbum')->name('musics.destroyAlbum');

Route::get('admin/musics/createByAlbum', 'Admin\MusicsController@createByAlbum')->name('musics.createByAlbum');
Route::get('/json_albums','Admin\MusicsController@json_albums');
Route::resource('admin/musics', 'Admin\MusicsController');

//PRODUCTS
//Category
Route::get('admin/products/createCategory', 'Admin\ProductsController@createCategory')->name('products.createCategory');
Route::post('admin/products/storeCategory', 'Admin\ProductsController@storeCategory')->name('products.storeCategory');
Route::get('admin/products/{id}/editCategory', 'Admin\ProductsController@editCategory')->name('products.editCategory');
Route::put('admin/products/{id}/updateCategory', 'Admin\ProductsController@updateCategory')->name('products.updateCategory');
Route::delete('admin/products/{id}/destroyCategory', 'Admin\ProductsController@destroyCategory')->name('products.destroyCategory');
//SubCategory
Route::get('admin/products/createSubCategory', 'Admin\ProductsController@createSubCategory')->name('products.createSubCategory');
Route::post('admin/products/storeSubCategory', 'Admin\ProductsController@storeSubCategory')->name('products.storeSubCategory');
Route::get('admin/products/{id}/editSubCategory', 'Admin\ProductsController@editSubCategory')->name('products.editSubCategory');
Route::put('admin/products/{id}/updateSubCategory', 'Admin\ProductsController@updateSubCategory')->name('products.updateSubCategory');
Route::delete('admin/products/{id}/destroySubCategory', 'Admin\ProductsController@destroySubCategory')->name('products.destroySubCategory');

Route::get('/json_sub_categories','Admin\ProductsController@json_sub_categories');
Route::resource('admin/products', 'Admin\ProductsController');


//DEFAULT
Auth::routes();
Route::get('/user/home', 'HomeController@index')->name('home');

Route::get('/admin/home', 'HomeController@someAdminStuff')->name('home');

Auth::routes();
Route::get('/user/home', 'HomeController@index')->name('home');

Route::get('/admin/home', 'HomeController@someAdminStuff')->name('home');
