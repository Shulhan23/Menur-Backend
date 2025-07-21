<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;

/*
|--------------------------------------------------------------------------
| API Routes - Versi Aman, Modern & Siap Produksi
|--------------------------------------------------------------------------
| Semua route otomatis prefiks dengan /api
| Ditambahkan /v1 sebagai penanda versi API
| Digunakan prinsip RESTful & middleware keamanan
*/

Route::prefix('v1')->group(function () {

    // 🔐 Login tanpa throttle
    // Route::post('/login', [AuthController::class, 'login']);

    // 📰 Endpoint berita tanpa throttle
    Route::middleware(['skipThrottle'])->group(function () {
        Route::get('/berita', [BeritaController::class, 'index']);
        Route::get('/berita/{id}', [BeritaController::class, 'show']);
    });

    // 🔒 Endpoint yang butuh login
    Route::middleware('auth:sanctum')->group(function () {
    Route::post('/berita', [BeritaController::class, 'store']);
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);
    Route::match(['put', 'patch'], '/berita/{id}', [BeritaController::class, 'update']);

    // Route::post('/logout', [AuthController::class, 'logout']);

    // ✅ Tambahan penting untuk verifikasi login dari frontend
    Route::get('/check-auth', function (Request $request) {
        return response()->json([
            'authenticated' => true,
            'user' => $request->user()
        ]);
    });

    Route::post('/change-password', function (Request $request) {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = auth()->user();
        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Password berhasil diubah']);
    });
});


    // ❌ Jika salah URL
    Route::fallback(function () {
        return response()->json([
            'message' => 'Halaman tidak ditemukan. Cek kembali URL API kamu.'
        ], 404);
    });
});


