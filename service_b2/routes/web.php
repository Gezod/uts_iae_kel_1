<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MenuController;           // Untuk View/UI

// Halaman utama
// Route::get('/', function () {
//     return Inertia::render('menus');
// });

// Route khusus untuk halaman UI (pakai MenuController)
Route::prefix('/menus')->controller(MenuController::class)->group(function () {
    Route::get('/', 'index');             // Tampilkan halaman daftar
    Route::get('/create', 'create');      // Form tambah
    Route::get('/{id}', 'show');          // Detail
    Route::get('/{id}/edit', 'edit');     // Form edit
});
