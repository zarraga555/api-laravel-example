<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\UnitMeasureController;
use App\Http\Controllers\Api\CategoryController;
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
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category', [CategoryController::class, 'store'])->name('api.store.category');
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('api.show.category');
Route::put('/category/{id}', [CategoryController::class, 'update'])->name('api.update.category');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('api.delete.category');

//});

//Route::middleware('auth:sanctum')->group(function () {
Route::get('/unit-measure', [UnitMeasureController::class, 'index']);
Route::post('/unit-measure', [UnitMeasureController::class, 'store'])->name('api.store.unitMeasure');
Route::get('/unit-measure/{id}', [UnitMeasureController::class, 'show'])->name('api.show.unitMeasure');
Route::put('/unit-measure/{id}', [UnitMeasureController::class, 'update'])->name('api.update.unitMeasure');
Route::delete('/unit-measure/{id}', [UnitMeasureController::class, 'destroy'])->name('api.delete.unitMeasure');

//});
