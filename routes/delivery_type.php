<?php

use App\Http\Controllers\Admin\DeliveryTypeController;
use Illuminate\Support\Facades\Route;
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
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin/delivery-type')->group(function () {
    Route::get('/', [DeliveryTypeController::class, 'admin_index'])->name('delivery_type.admin.index');
    Route::get('/create', [DeliveryTypeController::class, 'admin_create'])->name('delivery_type.admin.create');
    Route::get('/edit/{id}', [DeliveryTypeController::class, 'admin_edit'])->name('delivery_type.admin.edit');
    Route::post('/store', [DeliveryTypeController::class, 'admin_store'])->name('delivery_type.admin.store');
    Route::post('/update/{id}', [DeliveryTypeController::class, 'admin_update'])->name('delivery_type.admin.update');
    Route::get('/destroy/{id}', [DeliveryTypeController::class, 'admin_destroy'])->name('delivery_type.admin.destroy');
});

