<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\OrdersController;
use \App\Http\Controllers\Admin\TransactionsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/orders')->group(function () {
    Route::get('/{status?}', [OrdersController::class, 'admin_index'])->name('orders.admin.index');
    Route::get('{id}/details', [OrdersController::class, 'admin_details'])->name('orders.admin.details');
    Route::post('{id}/update', [OrdersController::class, 'admin_update'])->name('orders.admin.update');
});
//Route::middleware(['auth:sanctum', 'verified'])->prefix('admin/transactions')->group(function () {
//    Route::get('/', [TransactionsController::class, 'admin_index'])->name('transactions.admin.index');
//    Route::get('{id}/details', [TransactionsController::class, 'admin_details'])->name('transactions.admin.details');
//    Route::post('{id}/update', [TransactionsController::class, 'admin_update'])->name('transactions.admin.update');
//});

