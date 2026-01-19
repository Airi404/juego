<?php

use App\Http\Controllers\Api\ErrorController;
use Illuminate\Support\Facades\Route;

// Objetivo: Comprobar el estado del servidor [cite: 14]
Route::get('/status', function () {
    return response()->json([
        'status' => 'running',
        'date' => now()
    ]);
});

// Objetivo: Gestión de informes de error [cite: 34, 49, 53, 63]
Route::get('/errors', [ErrorController::class, 'index']);
Route::get('/errors/{code}', [ErrorController::class, 'show']);
Route::post('/errors', [ErrorController::class, 'store']);