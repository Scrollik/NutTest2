<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumcreateController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Все альбомы
Route::get('/',[AlbumController::class,'index'])->name('album.index');
// Все артисты
Route::get('/artists',[ArtistController::class,'index'])->name('artist.index');

Route::group(['middleware' => 'guest'],function (){
    // Регистрация
    Route::get('/register',[RegisterController::class,'create'])->name('register');
    Route::post('/register',[RegisterController::class,'store'])->name('register.post');
    // Авторизация
    Route::get('/login',[LoginController::class,'create'])->name('login');
    Route::post('/login',[LoginController::class,'store'])->name('login.post');
});
Route::group(['middleware' => 'auth'],function (){
//    Роуты альбома
    Route::get('/albumcreate',[AlbumController::class,'create'])->name('album.create');
    Route::get('/albumfindapi',[AlbumController::class,'findAlbumApi'])->name('album.findapi');
    Route::post('/albumstore',[AlbumController::class,'store'])->name('album.store');
    Route::get('/album/{id}',[AlbumController::class,'edit'])->name('album.edit')
        ->where('id', '[0-9]+');
    Route::put('/albumupdate',[AlbumController::class,'updateAlbum'])->name('album.update');
    Route::delete('/albumdelete/{id}',[AlbumController::class,'destroy'])->name('album.destroy')
        ->where('id', '[0-9]+');
//    Роуты исполнителя
    Route::get('/artistcreate',[ArtistController::class,'create'])->name('artist.create');
    Route::get('/artistfindapi',[ArtistController::class,'findArtistApi'])->name('artist.findapi');
    Route::post('/artiststore',[ArtistController::class,'store'])->name('artist.store');
    Route::get('/artist/{id}',[ArtistController::class,'edit'])->name('artist.edit')
    ->where('id', '[0-9]+');
    Route::put('/artistupdate',[ArtistController::class,'update'])->name('artist.update');
    Route::delete('/artistdelete/{id}',[ArtistController::class,'destroy'])->name('artist.destroy')
        ->where('id', '[0-9]+');
    // Выход с аккаунта
    Route::post('/logout',[LoginController::class,'destroy'])->name('logout');
});


