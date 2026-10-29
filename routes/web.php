<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WisataController;

/*
|--------------------------------------------------------------------------
| Wisatawan Routes (Custom UI — Jelajah Nusa)
|--------------------------------------------------------------------------
*/

// Landing page (public)
Route::get('/', [WisataController::class, 'landing'])->name('landing');

// Auth routes (custom wisatawan UI)
Route::get('/login', [WisataController::class, 'halamanLogin'])->name('login');
Route::post('/login-proses', [WisataController::class, 'prosesLogin']);
Route::get('/register', [WisataController::class, 'halamanRegister']);
Route::post('/register-proses', [WisataController::class, 'prosesRegister']);
Route::get('/register-sukses', [WisataController::class, 'registerSukses']);
Route::get('/logout', [WisataController::class, 'logout']);
Route::post('/logout', [WisataController::class, 'logout']);

// SEMENTARA — lihat struktur database (hanya jalan saat APP_DEBUG=true). Hapus sebelum dikumpulkan.
Route::get('/debug/skema', [WisataController::class, 'debugSkema']);

// Paket Wisata (public — bisa lihat tanpa login)
Route::get('/paket-wisata', [WisataController::class, 'tampilPaket'])->name('paket.index');
Route::get('/paket-wisata/{id}', [WisataController::class, 'detailPaket'])->name('paket.detail');

// Authenticated Wisatawan routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [WisataController::class, 'dashboardWisatawan'])->name('dashboard');

    // Pemesanan wizard
    Route::get('/pemesanan/step1/{id}', [WisataController::class, 'pemesananStep1'])->name('pemesanan.step1');
    Route::get('/pemesanan/step2/{id}', [WisataController::class, 'pemesananStep2'])->name('pemesanan.step2');
    Route::get('/pemesanan/step3/{id}', [WisataController::class, 'pemesananStep3'])->name('pemesanan.step3');
    Route::post('/pesan-paket', [WisataController::class, 'prosesPesan']);

    // Pesanan Saya
    Route::get('/pesanan-saya', [WisataController::class, 'pesananSaya'])->name('pesanan.index');
    Route::get('/pesanan-saya/{id}', [WisataController::class, 'detailPesanan'])->name('pesanan.detail');

    // Pembayaran
    Route::get('/pembayaran', [WisataController::class, 'tampilPembayaran'])->name('pembayaran');
    Route::get('/pembayaran/{id}', [WisataController::class, 'halamanBayar'])->name('pembayaran.detail');
    Route::post('/proses-bayar', [WisataController::class, 'prosesBayar']);

    // Tiket
    Route::get('/tiket', [WisataController::class, 'tampilTiket'])->name('tiket');
    Route::get('/tiket/{id}', [WisataController::class, 'detailTiket'])->name('tiket.detail');

    // Custom Trip
    Route::get('/custom-trip', [WisataController::class, 'tampilCustomTrip'])->name('custom-trip');
    Route::get('/custom-trip/daftar', [WisataController::class, 'daftarCustomTrip'])->name('custom-trip.daftar');
    Route::post('/custom-trip/kirim', [WisataController::class, 'kirimCustomTrip'])->name('custom-trip.kirim');

    // Legacy routes kept for Admin panel compatibility
    Route::get('/pemesanan', [WisataController::class, 'tampilPemesanan']);
    Route::get('/verifikasi-pembayaran/{id}', [WisataController::class, 'verifikasiPembayaran']);
    Route::get('/peserta', [WisataController::class, 'tampilPeserta']);
    Route::get('/laporan', [WisataController::class, 'tampilLaporan']);
    Route::get('/pengembalian', [WisataController::class, 'tampilPengembalian']);
    Route::get('/users', [WisataController::class, 'tampilUsers']);
    Route::get('/jadwal-keberangkatan', [WisataController::class, 'tampilJadwal']);
    Route::get('/kendaraan', [WisataController::class, 'tampilKendaraan']);

    // Profil & akun
    Route::get('/profil', [WisataController::class, 'profil'])->name('profil');
    Route::post('/profil', [WisataController::class, 'updateProfil'])->name('profil.update');
    Route::get('/ubah-password', [WisataController::class, 'ubahPassword'])->name('password.ubah');
    Route::post('/ubah-password', [WisataController::class, 'prosesUbahPassword'])->name('password.proses');
});
