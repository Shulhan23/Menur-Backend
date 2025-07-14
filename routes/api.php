<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;

/*
|--------------------------------------------------------------------------
| Public Routes (tanpa login)
|--------------------------------------------------------------------------
*/
Route::prefix('public')->group(function () {
    Route::get('/berita', [BeritaController::class, 'index']);
    Route::get('/berita/{id}', [BeritaController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/check', fn () => response()->json(['message' => 'Authenticated'], 200));

        Route::prefix('admin')->group(function () {
            Route::get('/berita', [BeritaController::class, 'index']);
            Route::post('/berita', [BeritaController::class, 'store']);
            Route::get('/berita/{id}', [BeritaController::class, 'show']);
            Route::put('/berita/{id}', [BeritaController::class, 'update']);
            Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);
        });
    });

    Route::fallback(function () {
        return response()->json([
            'message' => 'Halaman tidak ditemukan. Periksa kembali URL API kamu.'
        ], 404);
    });
});
