<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\StudioController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register');
Route::redirect('/register', '/registro');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Estudio Códice Creative Workspace Routes
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('studio.canvas');
    }

    return redirect()->route('login');
})->name('studio.index');
Route::get('/lienzo', [StudioController::class, 'canvas'])->name('studio.canvas');
Route::get('/personajes', [StudioController::class, 'characters'])->name('studio.characters');
Route::get('/mapas', [StudioController::class, 'maps'])->name('studio.maps');
Route::get('/biblioteca', [StudioController::class, 'library'])->name('studio.library');
