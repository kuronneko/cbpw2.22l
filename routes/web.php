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

Route::resource("admin/album", "admin\AlbumController", ['as' => 'admin']);
Route::resource("admin/image", "admin\ImageController", ['as' => 'admin']);
Route::resource("admin/comment", "admin\CommentController", ['as' => 'admin']);
Route::resource("admin/imagec", "admin\ImagecController", ['as' => 'admin']);

Route::get('admin/album/{id}/createImage', 'admin\AlbumController@createImage')->name('admin.album.createImage');
Route::get('admin/album/{id}/showImage', 'admin\AlbumController@showImage')->name('admin.album.showImage');
Route::post('admin/album/fetchAlbum', 'admin\AlbumController@fetchAlbum')->name('admin.album.fetchAlbum');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


