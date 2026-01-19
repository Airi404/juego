<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PixelProject
|--------------------------------------------------------------------------
*/

// --- RUTAS PÚBLICAS ---
// Redirige siempre a home como solicitaste
Route::get('/', [PageController::class, 'homepage'])->name('home');

// --- SOLO INVITADOS (Login/Registro) ---
Route::middleware('guest')->group(function () {
    Route::get('/registro', function () { return view('registro'); });
    Route::post('/registro', [PageController::class, 'register']);
    
    // Ruta de Login (necesaria para el middleware 'auth')
    Route::get('/login', function () { return view('login'); })->name('login'); 
    Route::post('/login', [PageController::class, 'login']);
});

// --- RUTAS PROTEGIDAS (Solo usuarios autenticados) ---
Route::middleware('auth')->group(function () {
    
    Route::get('/game/{id}/leave', [GameController::class, 'leave'])->name('game.leave');
    // TASK 9: TIENDA / MARKETPLACE
    // Muestra la lista y el formulario de creación en la misma vista
    Route::get('/tienda', [ProductController::class, 'index'])->name('tienda.index');
    Route::post('/productos', [ProductController::class, 'store'])->name('tienda.store');
    
    // TASK 10: TIC TAC TOE (Sistema de Salas)
    // 1. Listado de salas y formulario de creación (Task 10.1)
    Route::get('/juegos', [GameController::class, 'index'])->name('game.list');
    Route::post('/game/create', [GameController::class, 'store'])->name('game.store');
    
    // 2. Vista del tablero y lógica de juego (Task 10.2, 10.4, 10.5)
    Route::get('/juego/{id}', [GameController::class, 'show'])->name('game.show');
    Route::post('/juego/{id}/move', [GameController::class, 'play'])->name('game.play');
    
    // 3. Eliminar sala al finalizar (Task 10.6)
    Route::delete('/juego/{id}/delete', [GameController::class, 'destroy'])->name('game.destroy');    
    // TASK 6: PERFIL Y AVATAR
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/perfil/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    
    // TASK 5: PERSONA DINÁMICA (Slugs)
    Route::get('/persona/{slug}', [PageController::class, 'showPerson'])->name('person.show');
    
    // TASK 8: LOGOUT
    Route::post('/logout', [PageController::class, 'logout'])->name('logout');
});