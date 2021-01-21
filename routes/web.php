<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic;

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

Route::resource("album", "AlbumController");
Route::resource("image", "ImageController");
Route::resource("comment", "CommentController");
Route::resource("imagec", "ImagecController");

Route::get('album/{id}/createImage', 'AlbumController@createImage')->name('album.createImage');
Route::get('album/{id}/showImage', 'AlbumController@showImage')->name('album.showImage');
Route::post('album/fetchAlbum', 'AlbumController@fetchAlbum')->name('album.fetchAlbum');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('image/upload', 'ImageController@upload')->name('image.upload');
Route::get('image/fetch', 'ImageController@fetch')->name('image.fetch');
Route::get('image/delete', 'ImageController@delete')->name('image.delete');

