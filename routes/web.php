<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ControllerHalamanUtama;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ControllerHalamanUtama::class, 'index'])->middleware('guest');

Auth::routes();

//router admin
Route::group(['middleware' => ['CekUser:user']], function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('more', [App\Http\Controllers\HomeController::class, 'readMore'])->name('more');
    Route::get('all', [App\Http\Controllers\HomeController::class, 'viewAll'])->name('all');
    Route::post('like', [App\Http\Controllers\HomeController::class, 'like'])->name('like');
    Route::resource('artikel', ArtikelController::class);
    // Route::resource('like', LikeController::class);
});