<?php

use App\Http\Controllers\Admin\DriverController;

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

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/driver')->group(function () {
    Route::get('/', [DriverController::class, 'admin_index'])->name('driver.admin.index');
    Route::get('warn/', [DriverController::class, 'admin_warn'])->name('driver.admin.warn');
    Route::get('/create', [DriverController::class, 'admin_create'])->name('driver.admin.create');
    Route::post('/update/{id}', [DriverController::class, 'admin_update'])->name('driver.admin.update');
    Route::post('/store', [DriverController::class, 'admin_store'])->name('driver.admin.store');
    Route::get('/edit/{id}', [DriverController::class, 'admin_edit'])->name('driver.admin.edit');
    Route::get('/excel-drivers', [DriverController::class, 'handleExcelDrivers'])->name('driver.admin.excel_drivers');

    Route::get('/online', [DriverController::class, 'admin_online'])->name('driver.admin.online');
    Route::get('/onlinemap', [DriverController::class, 'admin_onlinemap'])->name('driver.admin.onlinemap');

    Route::get('/log', [DriverController::class, 'log'])->name('driver.admin.log');
    Route::get('/payment', [DriverController::class, 'payment'])->name('driver.admin.payment');
    Route::post('/payment_store', [DriverController::class, 'payment_store'])->name('driver.admin.payment_store');
    Route::get('/payment_create/{id?}', [DriverController::class, 'payment_create'])->name('driver.admin.payment_create');
    Route::get('/payment_create_info/{go_id?}/{phone?}', [DriverController::class, 'payment_create_info'])->name('driver.admin.payment_create_info');
    Route::post('/payment/refund-payment-trip/{go_id}', [DriverController::class, 'doRefundToPaymentTrip'])->name('driver.admin.payment.refund_payment_trip');
    Route::get('/export-payment-request', [DriverController::class, 'handleExportPaymentRequest'])->name('driver.admin.export_payment_request');

    Route::get('/payment_approve', [DriverController::class, 'payment_approve'])->name('driver.admin.payment_approve');
    Route::post('/payment_addmoney/{id}', [DriverController::class, 'payment_addmoney'])->name('driver.admin.payment_addmoney');
    Route::post('/payment_remove/{id}', [DriverController::class, 'payment_remove'])->name('driver.admin.payment_remove');
    Route::post('/payment_remove_user/{id}', [DriverController::class, 'payment_remove_user'])->name('driver.admin.payment_remove_user');
    Route::get('/payment_log', [DriverController::class, 'payment_log'])->name('driver.admin.payment_log');
    Route::get('/export-payment-log', [DriverController::class, 'handleExportPaymentLog'])->name('driver.admin.export_payment_log');


    //tai xe đăng  ký  chạy  dịch  vu  nàoo
    Route::get('/drservice/{driver_id}', [DriverController::class, 'admin_drservice'])->name('driver.admin.drservice');
    Route::get('/drservicedelete/{id}', [DriverController::class, 'admin_drserviceedelete'])->name('driver.admin.drservicedelete');
    Route::get('/drserviceactive/{id}', [DriverController::class, 'admin_drserviceactive'])->name('driver.admin.drserviceactive');
    Route::get('/drserviceallow/{id}', [DriverController::class, 'admin_drserviceallow'])->name('driver.admin.drserviceallow');


    Route::get('/drservicestore/{driver_id}/{service_detail_id}', [DriverController::class, 'admin_drservicestore'])->name('driver.admin.drservicestore');
    Route::get('/percent/{driver_id}/{service_detail_id}/{percent}', [DriverController::class, 'admin_percent'])->name('driver.admin.percent');

    Route::post('/sync-driver-gsm/{id}', [DriverController::class, 'syncDriverGsm'])->name('driver.admin.sync-driver-gsm');
//
});
