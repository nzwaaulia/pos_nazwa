<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

// Route untuk User Terautentikasi (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route Informasi
    Route::get('/tentang', function () {
        return view('tentang');
    })->name('tentang');

    Route::get('/profil-toko', function () {
        return view('profiltoko');
    })->name('profiltoko');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Khusus Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Route Khusus Admin & Kasir
    Route::middleware('role:admin,kasir')->group(function () {
        Route::resource('/produk', ProdukController::class);
        
        // Cukup deklarasi sederhana seperti ini (otomatis membuat rute penjualan.index, penjualan.create, penjualan.store, dll)
        Route::resource('/penjualan', PenjualanController::class);

        Route::resource('/itempenjualan', ItemPenjualanController::class);

        Route::get('/admin/penjualan/{penjualan}', [PenjualanController::class, 'show'])
            ->name('admin.penjualan.show');
    });
});