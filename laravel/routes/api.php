<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\VideoController;


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
Route::get('/peliserie/{idpeliserie}/comments', [CommentController::class, 'comments']);
Route::post('/peliserie/{idpeliserie}/comment', [CommentController::class, 'comment'])->middleware(['auth:sanctum']);
Route::delete('/peliserie/uncomment/{comment}', [CommentController::class, 'uncomment'])->middleware(['auth:sanctum']);
Route::post('/videos', [VideoController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/videos/{peli}', [VideoController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/videos/{peli}', [VideoController::class, 'destroy'])->middleware(['auth:sanctum']);
Route::get('/videos', [VideoController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/videos/{peli}', [VideoController::class, 'show'])->middleware(['auth:sanctum']);

