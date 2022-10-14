<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CreatorController;

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
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/article', [ArticleController::class, 'index'])->name('article')->middleware('auth');
Route::get('/article', [ArticleController::class, 'index'])->name('article')->middleware('auth');
Route::get('/article-create', [ArticleController::class, 'create'])->name('article.create')->middleware('auth');
Route::post('/article', [ArticleController::class, 'store'])->name('article.store')->middleware('auth');
Route::get('/article/{id}', [ArticleController::class, 'edit'])->name('article.edit')->middleware('auth');
Route::put('/article/{id}', [ArticleController::class, 'update'])->name('article.update')->middleware('auth');
Route::delete('/article/{id}', [ArticleController::class, 'destroy'])->name('article.destroy')->middleware('auth');


Route::get('/creator', [CreatorController::class, 'index'])->name('creator')->middleware('auth');
Route::get('/creator-create', [CreatorController::class, 'create'])->name('creator.create')->middleware('auth');
Route::post('/creator', [CreatorController::class, 'store'])->name('creator.store')->middleware('auth');
Route::get('/creator/{id}', [CreatorController::class, 'edit'])->name('creator.edit')->middleware('auth');
Route::put('/creator/{id}', [CreatorController::class, 'update'])->name('creator.update')->middleware('auth');
Route::delete('/creator/{id}', [CreatorController::class, 'destroy'])->name('creator.destroy')->middleware('auth');