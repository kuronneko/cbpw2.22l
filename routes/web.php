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
    Route::get('super/profile', function () {
        return view('super.profile.index');
    });
    // Routes to modify the profile images though the super admin panel
    Route::post('super/album/store', [ImageController::class, 'store'])->name('super.image.store');
    Route::get('super/album/{id}/createImage', [ImageController::class, 'createImage'])->name('super.image.createImage');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('album/@cbpw0{id}/', [WebController::class, 'showContent'])->name('album.content');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
