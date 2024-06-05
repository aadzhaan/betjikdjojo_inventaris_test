<?php

use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KategoriBarangController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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