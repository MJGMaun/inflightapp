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

    /*****************************
            MOVIES
    *****************************/
Route::resource('admin/games', 'Admin\GamesController');

    /*****************************
            MOVIES
    *****************************/
Route::resource('movies', 'MoviesController');
Route::resource('admin/movies', 'Admin\MoviesController');

    /*****************************
            SERIES
    *****************************/
    // SEASON
Route::get('admin/series/createSeason', 'Admin\SeriesController@createSeason');
Route::post('admin/series/storeSeason', 'Admin\SeriesController@storeSeason');
Route::get('admin/series/{id}/editSeason', 'Admin\SeriesController@editSeason');
Route::put('admin/series/{id}/updateSeason', 'Admin\SeriesController@updateSeason');
Route::delete('admin/series/{id}/destroySeason', 'Admin\SeriesController@destroySeason');
    //EPISODE
Route::get('admin/series/{id}/editEpisode', 'Admin\SeriesController@editEpisode');
Route::put('admin/series/{id}/updateEpisode', 'Admin\SeriesController@updateEpisode');
Route::delete('admin/series/{id}/destroyEpisode', 'Admin\SeriesController@destroyEpisode');
    //OTHERS
Route::get('/json_seasons','Admin\SeriesController@json_seasons');
Route::get('/json_seasons_modal','Admin\SeriesController@json_seasons_modal');
Route::resource('admin/series', 'Admin\SeriesController');

    /*****************************
            ADS
    *****************************/
Route::resource('admin/ads', 'Admin\AdsController');

    /*****************************
            MUSIC
    *****************************/
Route::get('admin/musics/{id}/createWId', 'Admin\MusicsController@createWId');
Route::get('admin/musics/{id}/createAlbumWId', 'Admin\MusicsController@createAlbumWId');



    /*****************************
            ARTIST
    *****************************/
Route::get('admin/musics/createArtist', 'Admin\MusicsController@createArtist');
Route::post('admin/musics/storeArtist', 'Admin\MusicsController@storeArtist');
Route::get('admin/musics/{id}/editArtist', 'Admin\MusicsController@editArtist');
Route::put('admin/musics/{id}/updateArtist', 'Admin\MusicsController@updateArtist');
Route::delete('admin/musics/{id}/destroyArtist', 'Admin\MusicsController@destroyArtist');
    /*****************************
            ALBUM
    *****************************/
Route::get('admin/musics/{id}/editAlbum', 'Admin\MusicsController@editAlbum');
Route::put('admin/musics/{id}/updateAlbum', 'Admin\MusicsController@updateAlbum');
Route::delete('admin/musics/{id}/destroyAlbum', 'Admin\MusicsController@destroyAlbum');

Route::get('admin/musics/createByAlbum', 'Admin\MusicsController@createByAlbum');
Route::get('/json_albums','Admin\MusicsController@json_albums');
Route::resource('admin/musics', 'Admin\MusicsController');

    /*****************************
            PRODUCTS
    *****************************/
//Category
Route::get('admin/products/createCategory', 'Admin\ProductsController@createCategory');
Route::post('admin/products/storeCategory', 'Admin\ProductsController@storeCategory');
Route::get('admin/products/{id}/editCategory', 'Admin\ProductsController@editCategory');
Route::put('admin/products/{id}/updateCategory', 'Admin\ProductsController@updateCategory');
Route::delete('admin/products/{id}/destroyCategory', 'Admin\ProductsController@destroyCategory');
//SubCategory
Route::get('admin/products/createSubCategory', 'Admin\ProductsController@createSubCategory');
Route::post('admin/products/storeSubCategory', 'Admin\ProductsController@storeSubCategory');
Route::get('admin/products/{id}/editSubCategory', 'Admin\ProductsController@editSubCategory');
Route::put('admin/products/{id}/updateSubCategory', 'Admin\ProductsController@updateSubCategory');
Route::delete('admin/products/{id}/destroySubCategory', 'Admin\ProductsController@destroySubCategory');

Route::get('/json_sub_categories','Admin\ProductsController@json_sub_categories');
Route::resource('admin/products', 'Admin\ProductsController');


    /*****************************
            DEFAULT
    *****************************/
Auth::routes();
Route::get('/user/home', 'HomeController@index');

Route::get('/admin/home', 'HomeController@someAdminStuff');

Auth::routes();
Route::get('/user/home', 'HomeController@index');

Route::get('/admin/home', 'HomeController@someAdminStuff');
