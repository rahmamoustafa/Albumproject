<?php

use App\Http\Controllers\Api\AlbumController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',[AuthController::class,'login'])->name('api.login');
Route::post('register',[AuthController::class,'register'])->name('api.register');
Route::post('logout',[AuthController::class,'logout'])->name('api.logout');
Route::post('me',[AuthController::class,'getAuthenticatedUser'])->name('api.me');
Route::resource('albums',AlbumController::class)->except(['edit','create']);
