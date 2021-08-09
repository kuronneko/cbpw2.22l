<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
Route::resource("admin/profile", "admin\ProfileController", ['as' => 'admin']);

Route::resource("super/tag", "super\SuperTagController", ['as' => 'super']);
Route::resource("super/user", "super\SuperUserController", ['as' => 'super']);

Route::get('admin/album/{id}/createImage', 'admin\ImageController@createImage')->name('admin.image.createImage');
Route::get('admin/album/{id}/showImage', 'admin\ImageController@showImage')->name('admin.image.showImage');
Route::post('admin/album/fetchAlbum', 'admin\AlbumController@fetchAlbum')->name('admin.album.fetchAlbum');
Route::get('admin/album/{id}/showComment', 'admin\CommentController@showComment')->name('admin.comment.showComment');

Route::get('admin/album/{id}/showTag', 'admin\TagController@showTag')->name('admin.tag.showTag');

//Route::resource("comment", "PublicCommentController");
Route::resource("/", "PublicAlbumController");
Route::get('folder/{id}/', 'PublicImageController@showContent')->name('image.content');
//Route::post('content/reloadComments', 'PublicCommentController@reloadComments')->name('comment.reloadComments');
//Route::post('content/commentAjaxLoad', 'PublicCommentController@commentAjaxLoad')->name('comment.commentAjaxLoad');
//Route::post('content/getTotalComments', 'PublicCommentController@getTotalComments')->name('comment.getTotalComments');

//Route::get('/getAjaxAlbums', 'PublicAlbumController@getAjaxAlbums')->name('album.getAjaxAlbums');

//Auth::routes();
Auth::routes([
    'register' => true, // Registration Routes...
    'reset' => true, // Password Reset Routes...
    'verify' => true, // Email Verification Routes...
  ]);
//Route::get('/livewire', [App\Http\Controllers\PublicAlbumController::class, 'livewire'])->name('livewire');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


