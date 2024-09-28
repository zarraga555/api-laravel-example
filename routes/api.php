<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store'])->name('api.store.user');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('api.show.user');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('api.update.user');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('api.delete.user');

//});

//Route::middleware('auth:sanctum')->group(function () {
    Route::get('/brand', [BrandController::class, 'index']);
    Route::post('/brand', [BrandController::class, 'store'])->name('api.store.brand');
    Route::get('/brand/{id}', [BrandController::class, 'show'])->name('api.show.brand');
    Route::put('/brand/{id}', [BrandController::class, 'update'])->name('api.update.brand');
    Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('api.delete.brand');

//});

//Route::middleware('auth:sanctum')->group(function () {
Route::get('/category', [BrandController::class, 'index']);
Route::post('/category', [BrandController::class, 'store'])->name('api.store.category');
Route::get('/category/{id}', [BrandController::class, 'show'])->name('api.show.category');
Route::put('/category/{id}', [BrandController::class, 'update'])->name('api.update.category');
Route::delete('/category/{id}', [BrandController::class, 'destroy'])->name('api.delete.category');

//});
