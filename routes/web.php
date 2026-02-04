<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ExternalApiController;
use Illuminate\Support\Facades\Route;
use Gemini\Laravel\Facades\Gemini; // Asegúrate de tener este import si usas el facade

/*
|--------------------------------------------------------------------------
| Web Routes - PixelProject
|--------------------------------------------------------------------------
*/

// --- RUTAS PÚBLICAS ---
Route::get('/', [PageController::class, 'homepage'])->name('home');
Route::get('/external-api', [ExternalApiController::class, 'index'])->name('api.external');

// --- TASK 15: AI CHATBOT (Gemini) ---
// Estas rutas permiten cumplir con el objetivo de crear un formulario y mostrar la respuesta[cite: 24, 30].
Route::get('/chatbot', [PageController::class, 'chatbotIndex'])->name('chatbot.index');
Route::post('/chatbot', [PageController::class, 'chatbotSendMessage'])->name('chatbot.send');

// Ruta de test rápido (opcional, para verificar el Objetivo 3) [cite: 17, 23]
Route::get('/test-ai', function () {
    $result = Gemini::geminiFlash()->generateContent("Say hello!");
    return $result->text();
});

// --- SOLO INVITADOS (Guest) ---
Route::middleware('guest')->group(function () {
    Route::get('/registro', function () { return view('registro'); });
    Route::post('/registro', [PageController::class, 'register']);
    Route::get('/login', function () { return view('login'); })->name('login'); 
    Route::post('/login', [PageController::class, 'login']);
});

// --- SOLO USUARIOS AUTENTICADOS (Auth) ---
Route::middleware('auth')->group(function () {
    
    // --- TASK 10 & 11: TIC TAC TOE ---
    Route::get('/juego/{id}/leave', [GameController::class, 'leave'])->name('game.leave');
    Route::get('/juegos', [GameController::class, 'index'])->name('game.list');
    Route::post('/game/create', [GameController::class, 'store'])->name('game.store');
    Route::get('/juego/{id}', [GameController::class, 'show'])->name('game.show');
    Route::post('/juego/{id}/move', [GameController::class, 'play'])->name('game.play');
    Route::delete('/juego/{id}/delete', [GameController::class, 'destroy'])->name('game.destroy');

    // --- TASK 9: TIENDA / MARKETPLACE ---
    Route::get('/tienda', [ProductController::class, 'index'])->name('tienda.index');
    Route::post('/productos', [ProductController::class, 'store'])->name('tienda.store');

    // --- TASK 6: PERFIL Y AVATAR ---
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/perfil/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    // --- TASK 5: PERSONA DINÁMICA (Slugs) ---
    Route::get('/persona/{slug}', [PageController::class, 'showPerson'])->name('person.show');

    // --- TASK 8: LOGOUT ---
    Route::post('/logout', [PageController::class, 'logout'])->name('logout');
});