<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/check', function () {
            return response()->json(['message' => 'Authenticated'], 200);
        });
    });

    Route::fallback(function () {
        return response()->json([
            'message' => 'Halaman tidak ditemukan. Periksa kembali URL API kamu.'
        ], 404);
    });
});
