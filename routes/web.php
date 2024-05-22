<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PictureController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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



Auth::routes();

Route::get('/', [App\Http\Controllers\AlbumController::class, 'index'])->name('home');


Route::get('album/list', [AlbumController::class, 'getAlbums'])->name('ablums.list');
Route::get('album/create', [AlbumController::class, 'create'])->name('ablum.add');
Route::post('album/store', [AlbumController::class, 'store'])->name('ablum.store');
Route::get('album/edit/{id}', [AlbumController::class, 'edit'])->name('ablum.edit');
Route::post('album/update/{id}', [AlbumController::class, 'update'])->name('ablum.update');
Route::get('album/delete/{id}', [AlbumController::class, 'destroy'])->name('ablum.delete');


Route::get('picture/show/{album_id}', [PictureController::class, 'index'])->name('pictures.show');
Route::post('picture/store/{id}', [PictureController::class, 'store'])->name('pictures.store');
Route::get('picture/delete/{id}', [PictureController::class, 'destroy'])->name('picture.delete');
Route::get('picture/change/{id}', [PictureController::class, 'change_album'])->name('picture.change.album');

