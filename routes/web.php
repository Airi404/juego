<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'homepage'])->name('home');
Route::middleware('guest')->group(function () {
    Route::get('/registro', function () { return view('registro'); });
    Route::post('/registro', [PageController::class, 'register']);
    Route::get('/login', function () { return view('login'); }); 
    Route::post('/login', [PageController::class, 'login']);
});

// Rutas protegidas (Solo registrados)
Route::middleware('auth')->group(function () {
    Route::get('/tienda', function () { return view('tienda'); });
    Route::get('/juego', function () { return view('juego'); });
    Route::post('/logout', [PageController::class, 'logout'])->name('logout');
});