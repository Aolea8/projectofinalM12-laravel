<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\FavoriteController;

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

Route::post('/register', [TokenController::class, 'register']);
Route::post('/login', [TokenController::class, 'login']);
Route::post('/logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [TokenController::class, 'user'])->middleware('auth:sanctum');
Route::post('/favorite/{movieserie}', [FavoriteController::class, 'favorite'])->middleware('auth:sanctum');
Route::delete('/unfavorite/{movieserie}', [FavoriteController::class, 'unfavorite'])->middleware('auth:sanctum');
Route::get('/user/favorites', [FavoriteController::class, 'index'])->middleware('auth:sanctum');

