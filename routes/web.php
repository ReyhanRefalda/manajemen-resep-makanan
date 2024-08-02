<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembuatController;
use App\Http\Controllers\LangkahController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::delete('/langkah/massdestroy', [LangkahController::class, 'massDestroy'])->name('langkah.massdestroy');
Route::get('/search-resep', [ResepController::class, 'searchResep'])->name('search-resep');
Route::get('/dashboard', [ResepController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', function () {
    return view('welcome');
});
Route::resource('resep', ResepController::class);
Route::resource('bahan', BahanController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('pembuat', PembuatController::class);
Route::resource('langkah', LangkahController::class);




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
