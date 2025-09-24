<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PengaduanController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
});


// Grup Route untuk Admin & Petugas
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Route yang bisa diakses oleh admin DAN petugas
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/pengaduan/{pengaduan}', [AdminController::class, 'show'])->name('pengaduan.show');
    Route::post('/tanggapan/{pengaduan}', [AdminController::class, 'storeTanggapan'])->name('tanggapan.store');

    // Route yang HANYA bisa diakses oleh admin
    Route::middleware('can:manage-system')->group(function () {
        Route::resource('users', UserController::class)->except(['show', 'destroy']);
        Route::resource('kategori', KategoriController::class);

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/generate', [LaporanController::class, 'generate'])->name('laporan.generate');
    });
});


require __DIR__ . '/auth.php';
