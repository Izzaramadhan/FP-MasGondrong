<?php

use Illuminate\Support\Facades\Route;

// Health check endpoint
Route::get('/health', function() {
    return response()->json([
        'success' => true,
        'message' => 'MasGondrong Rental API is running!',
        'timestamp' => now()->toISOString()
    ]);
});

// Kendaraan endpoints - return dummy data
Route::get('/kendaraan', function() {
    $dummyKendaraan = [
        [
            'id_kendaraan' => 1,
            'tipe' => 'Honda Beat',
            'jenis' => 'Motor Matic',
            'harga_perhari' => 75000,
            'nama' => 'Honda Beat',
            'gambar' => 'honda-beat.jpg',
            'harga' => 'Rp.75.000/hari'
        ],
        [
            'id_kendaraan' => 2,
            'tipe' => 'Toyota Avanza',
            'jenis' => 'Mobil MPV',
            'harga_perhari' => 350000,
            'nama' => 'Toyota Avanza',
            'gambar' => 'avanza.jpg',
            'harga' => 'Rp.350.000/hari'
        ],
        [
            'id_kendaraan' => 3,
            'tipe' => 'Honda Vario',
            'jenis' => 'Motor Matic',
            'harga_perhari' => 85000,
            'nama' => 'Honda Vario',
            'gambar' => 'honda-vario.jpg',
            'harga' => 'Rp.85.000/hari'
        ]
    ];

    return response()->json([
        'success' => true,
        'message' => 'Data kendaraan berhasil diambil dari API',
        'data' => $dummyKendaraan
    ]);
});

// Auth endpoints (dummy)
Route::post('/auth/register', function() {
    return response()->json([
        'success' => true,
        'message' => 'Registrasi berhasil! (Demo mode)'
    ]);
});

Route::post('/auth/login', function() {
    return response()->json([
        'success' => true,
        'message' => 'Login berhasil! (Demo mode)',
        'data' => [
            'token' => 'demo-token-123',
            'user' => [
                'nama' => 'Demo User',
                'email' => 'demo@example.com'
            ]
        ]
    ]);
});