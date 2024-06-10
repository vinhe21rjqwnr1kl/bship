<?php

use App\Http\Controllers\Admin\CustomerController;

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

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/customer')->group(function () {
    Route::get('/', [CustomerController::class, 'admin_index'])->name('customer.admin.index');


    Route::get('/notify', [CustomerController::class, 'admin_notify'])->name('custumer.admin.notify');
    Route::get('/notifydelete/{id}', [CustomerController::class, 'admin_notifydelete'])->name('custumer.admin.notifydelete');
    Route::get('/notifycreate/', [CustomerController::class, 'admin_notifycreate'])->name('custumer.admin.notifycreate');
    Route::post('/notifystore/', [CustomerController::class, 'admin_notifystore'])->name('custumer.admin.notifystore');
    Route::post('/notifyupdate/{id}', [CustomerController::class, 'admin_notifyupdate'])->name('custumer.admin.notifyupdate');


    Route::get('/banner', [CustomerController::class, 'admin_banner'])->name('custumer.admin.banner');
    Route::get('/banneredit/{id}', [CustomerController::class, 'admin_banneredit'])->name('custumer.admin.banneredit');
    Route::get('/bannerdeletet/{id}', [CustomerController::class, 'admin_bannerdelete'])->name('custumer.admin.bannerdelete');
    Route::get('/bannercreate/', [CustomerController::class, 'admin_bannercreate'])->name('custumer.admin.bannercreate');
    Route::post('/bannerstore/', [CustomerController::class, 'admin_bannerstore'])->name('custumer.admin.bannerstore');
    Route::post('/bannerupdate/{id}', [CustomerController::class, 'admin_bannerupdate'])->name('custumer.admin.bannerupdate');

    Route::get('/notifirebase', [CustomerController::class, 'admin_notifirebase'])->name('custumer.admin.notifirebase');
    Route::post('/notifirebasesend', [CustomerController::class, 'admin_notifirebasessend'])->name('custumer.admin.notifirebasesend');





});
