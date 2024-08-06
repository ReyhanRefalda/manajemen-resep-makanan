<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\LangkahController;
use App\Http\Controllers\PembuatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

// Halaman Login yang tidak memerlukan otentikasi
Route::get('/', function () {
    return view('auth.login');
});

// Rute yang memerlukan otentikasi
Route::middleware('auth')->group(function () {
    Route::delete('/langkah/massdestroy', [LangkahController::class, 'massDestroy'])->name('langkah.massdestroy');
    Route::get('/search-resep', [ResepController::class, 'searchResep'])->name('search-resep');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('resep', ResepController::class);
    Route::resource('bahan', BahanController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('pembuat', PembuatController::class);
    Route::resource('langkah', LangkahController::class);

    

    // Other routes that require authentication
});

require __DIR__.'/auth.php';
