<?php

use App\Http\Controllers\DivisiController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PenambahanController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/divisi')->name('divisi.')->group(function () {
    Route::get('/data', [DivisiController::class, 'data'])->name('data');
    Route::post('/store', [DivisiController::class, 'store'])->name('store');
    Route::post('/update', [DivisiController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [DivisiController::class, 'delete'])->name('delete');
});

Route::prefix('/kategori_barang')->name('kategori_barang.')->group(function () {
    Route::get('/data', [KategoriBarangController::class, 'data'])->name('data');
    Route::post('/store', [KategoriBarangController::class, 'store'])->name('store');
    Route::post('/update', [KategoriBarangController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [KategoriBarangController::class, 'delete'])->name('delete');
});

Route::prefix('/status')->name('status.')->group(function () {
    Route::get('/data', [StatusController::class, 'data'])->name('data');
    Route::post('/store', [StatusController::class, 'store'])->name('store');
    Route::post('/update', [StatusController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [StatusController::class, 'delete'])->name('delete');
});

Route::prefix('/inventaris')->name('inventaris.')->group(function () {
    Route::get('/data', [InventarisController::class, 'data'])->name('data');
    Route::get('/detail/{id}', [InventarisController::class, 'detail'])->name('detail');
    Route::post('/store', [InventarisController::class, 'store'])->name('store');
    Route::post('/update', [InventarisController::class, 'update'])->name('update');
    Route::post('/update_quantity/{jumlah}/{inventaris_id}/{status}', [InventarisController::class, 'update_quantity'])->name('update_quantity');
    Route::delete('/delete/{id}', [InventarisController::class, 'delete'])->name('delete');
});

Route::prefix('/user')->name('user.')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::get('/data', [UserController::class, 'data'])->name('data');
    Route::get('/detail/{id}', [UserController::class, 'detail'])->name('detail');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::post('/update', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
});

Route::prefix('/penambahan')->name('penambahan.')->group(function () {
    Route::get('/data', [PenambahanController::class, 'data'])->name('data');
    Route::get('/detail/{id}', [PenambahanController::class, 'detail'])->name('detail');
    Route::post('/store', [PenambahanController::class, 'store'])->name('store');
    Route::post('/update', [PenambahanController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PenambahanController::class, 'delete'])->name('delete');
    Route::post('/change_status', [PenambahanController::class, 'change_status'])->name('change_status');
});

Route::prefix('/permintaan')->name('permintaan.')->group(function () {
    Route::get('/data', [PermintaanController::class, 'data'])->name('data');
    Route::get('/detail/{id}', [PermintaanController::class, 'detail'])->name('detail');
    Route::post('/store', [PermintaanController::class, 'store'])->name('store');
    Route::post('/update', [PermintaanController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PermintaanController::class, 'delete'])->name('delete');
    Route::post('/change_status', [PermintaanController::class, 'change_status'])->name('change_status');
});

Route::prefix('/histori')->name('histori.')->group(function () {
    Route::get('/data', [HistoriController::class, 'data'])->name('data');
    Route::get('/detail/{id}', [HistoriController::class, 'detail'])->name('detail');
    Route::get('/inventaris/{id}', [HistoriController::class, 'inventaris'])->name('inventaris');
    Route::post('/store/{inventaris_id}/{kode}/{tanggal}/{jumlah}/{status}', [HistoriController::class, 'store'])->name('store');
});
