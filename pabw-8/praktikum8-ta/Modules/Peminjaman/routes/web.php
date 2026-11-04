<?php

use Illuminate\Support\Facades\Route;
use Modules\Peminjaman\Http\Controllers\PeminjamanController;

Route::middleware(['auth', 'role:admin,user'])->group(function () {
    Route::get('peminjamans', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjamans/data', [PeminjamanController::class, 'data'])->name('peminjaman.data');
    Route::get('peminjamans/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('peminjamans', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::put('peminjamans/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('peminjamans/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});
