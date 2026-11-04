<?php

use Illuminate\Support\Facades\Route;
use Modules\Buku\Http\Controllers\BukuController;

Route::middleware(['auth', 'role:admin,user'])->group(function () {
    Route::get('bukus', [BukuController::class, 'index'])->name('buku.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('bukus/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('bukus', [BukuController::class, 'store'])->name('buku.store');
    Route::get('bukus/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('bukus/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('bukus/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});
