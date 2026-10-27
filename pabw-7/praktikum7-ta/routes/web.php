<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('laporan.create');
});

// Form pelaporan warga, bisa dibuka tanpa login
Route::get('/lapor', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/lapor', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/lapor/berhasil/{laporan}', [LaporanController::class, 'berhasil'])->name('laporan.berhasil');

Route::get('/dashboard', function () {
    return redirect()->route('laporan.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Halaman pengelolaan laporan oleh petugas
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('laporan', LaporanController::class)->except(['create', 'store']);
});

require __DIR__ . '/auth.php';
