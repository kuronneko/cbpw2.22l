<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Super\ImageController;

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

Route::group(['middleware' => 'auth'], function () {
    // Redirect to the profile page
    Route::get("super/profile", [WebController::class, 'redirect'])->name('super.perfil.index');
    // Routes to modify the profile images though the super admin panel
    Route::post('super/album/store', [ImageController::class, 'store'])->name('super.image.store');
    Route::get('super/album/{id}/createImage', [ImageController::class, 'createImage'])->name('super.image.createImage');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('album/{id}/', [WebController::class, 'showContent'])->name('album.content');


/* Route::get('admin/album/{id}/showImage', 'admin\ImageController@showImage')->name('super.image.showImage'); */
/* Route::get('album/{id}/', 'PublicImageController@showContent')->name('album.content'); */
/* Route::get('admin/album/{id}/showComment', 'admin\CommentController@showComment')->name('super.comment.showComment'); */

/* Route::resource("admin/album", "admin\AlbumController", ['as' => 'admin']);
Route::resource("admin/image", "admin\ImageController", ['as' => 'admin']);
Route::resource("admin/comment", "admin\CommentController", ['as' => 'admin']);
Route::resource("admin/imagec", "admin\ImagecController", ['as' => 'admin']);
Route::resource("super/profile", "admin\ProfileController", ['as' => 'admin']);

Route::resource("super/tag", "super\SuperTagController", ['as' => 'super']);
Route::resource("super/user", "super\SuperUserController", ['as' => 'super']); */

/* Route::get('admin/album/{id}/createImage', 'admin\ImageController@createImage')->name('admin.image.createImage');
Route::get('admin/album/{id}/showImage', 'admin\ImageController@showImage')->name('admin.image.showImage');
Route::post('admin/album/fetchAlbum', 'admin\AlbumController@fetchAlbum')->name('admin.album.fetchAlbum');
Route::get('admin/album/{id}/showComment', 'admin\CommentController@showComment')->name('admin.comment.showComment'); */

/* Route::get('admin/album/{id}/showTag', 'admin\TagController@showTag')->name('admin.tag.showTag'); */

//Route::resource("comment", "PublicCommentController");
/* Route::resource("/", "PublicAlbumController"); */
/* Route::get('album/{id}/', 'PublicImageController@showContent')->name('album.content');
Route::get('video/{id}/', 'PublicImageController@showContent')->name('album.content-e'); */
//Route::post('content/reloadComments', 'PublicCommentController@reloadComments')->name('comment.reloadComments');
//Route::post('content/commentAjaxLoad', 'PublicCommentController@commentAjaxLoad')->name('comment.commentAjaxLoad');
//Route::post('content/getTotalComments', 'PublicCommentController@getTotalComments')->name('comment.getTotalComments');

//Route::get('/getAjaxAlbums', 'PublicAlbumController@getAjaxAlbums')->name('album.getAjaxAlbums');

//Auth::routes();
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);
//Route::get('/livewire', [App\Http\Controllers\PublicAlbumController::class, 'livewire'])->name('livewire');


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


