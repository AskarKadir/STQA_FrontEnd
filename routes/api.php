<?php

use App\Http\Controllers\API\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\UserController;

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
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::get('/username/search', [UserController::class, 'searchUsername'])->name('user.searchUsername');
Route::get('/email/search', [UserController::class, 'searchEmail'])->name('user.searchEmail');
Route::get('/telepon/search', [UserController::class, 'searchTelepon'])->name('user.searchTelepon');
Route::get('/token', [AuthController::class, 'getBearerToken'])->name('token');
Route::get('/isadmin', [AuthController::class, 'isadmin'])->name('auth.isadmin');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/riwayat/done', [OrderController::class, 'done'])->name('order.done');
    Route::get('/riwayat', [OrderController::class, 'index'])->name('order.index');
    Route::get('/incoming', [OrderController::class, 'incoming'])->name('order.incoming');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/riwayat/itemsales', [OrderController::class, 'totalitemssales'])->name('order.totalitemssales');
    Route::get('/riwayat/total', [OrderController::class, 'totalsales'])->name('order.total');
    Route::get('/riwayat/{username}', [OrderController::class, 'indexuser'])->name('order.indexuser');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::put('/order/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
});
