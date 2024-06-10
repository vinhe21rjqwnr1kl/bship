<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\LogAddMoneyController;
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
Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/log-add-money')->group(function () {
    Route::get('/cashout', [LogAddMoneyController::class, 'cashoutIndex'])->name('log_add_money.admin.cashout');
    Route::get('/cashout/accept/{id}', [LogAddMoneyController::class, 'cashoutAccept'])->name('log_add_money.admin.cashout.accept');
    Route::get('/cashout/reject/{id}', [LogAddMoneyController::class, 'cashoutReject'])->name('log_add_money.admin.cashout.reject');
    Route::get('/cashin', [LogAddMoneyController::class, 'cashinIndex'])->name('log_add_money.admin.cashin');
    Route::get('/cashin/accept/{id}', [LogAddMoneyController::class, 'cashinAccept'])->name('log_add_money.admin.cashin.accept');
    Route::get('/cashin/reject/{id}', [LogAddMoneyController::class, 'cashinReject'])->name('log_add_money.admin.cashin.reject');
});

