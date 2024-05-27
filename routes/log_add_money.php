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
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin/log-add-money')->group(function () {
    Route::get('/cashin', [LogAddMoneyController::class, 'index_cashin'])->name('log_add_money.admin.cashin');
    Route::get('/cashout', [LogAddMoneyController::class, 'index_cashout'])->name('log_add_money.admin.cashout');
});

