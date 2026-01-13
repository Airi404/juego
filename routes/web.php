<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController; // Importante añadir el nuevo controlador
use Illuminate\Support\Facades\Route;

// Pública
Route::get('/', [PageController::class, 'homepage'])->name('home');

// Solo invitados (Login/Registro)
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
    
    // --- NUEVAS RUTAS DE PERFIL ---
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/perfil/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    // ------------------------------
    Route::get('/persona/{slug}', [PageController::class, 'showPerson'])->name('person.show');

    Route::post('/logout', [PageController::class, 'logout'])->name('logout');
});