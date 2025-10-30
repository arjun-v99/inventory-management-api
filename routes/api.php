<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WarehouseController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'authenticateLogin']);

Route::get('/products', [ProductController::class, 'getProducts'])->middleware('auth:sanctum');
Route::post('/stock', [StockController::class, 'addOrUpdateStock'])->middleware('auth:sanctum');
Route::get('/warehouse/{id}/report', [WarehouseController::class, 'getWareHouseReport'])->middleware('auth:sanctum');
