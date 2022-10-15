<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ArticleController;

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


Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'creator'], function ($router) {
    Route::get('all', [CreatorController::class, 'all']);
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'article'], function ($router) {
    Route::get('all', [ArticleController::class, 'all']);
    Route::get('{id}', [ArticleController::class, 'show']);
    Route::post('store', [ArticleController::class, 'store']);
    Route::put('update/{id}', [ArticleController::class, 'update']);
    Route::delete('delete/{id}', [ArticleController::class, 'delete']);
});