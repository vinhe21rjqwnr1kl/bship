<?php

use App\Http\Controllers\Admin\DeliveryProductSizeController;
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
Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/delivery-product-size')->group(function () {
    Route::get('/', [DeliveryProductSizeController::class, 'admin_index'])->name('delivery_size.admin.index');
    Route::get('/create', [DeliveryProductSizeController::class, 'admin_create'])->name('delivery_size.admin.create');
    Route::get('/edit/{id}', [DeliveryProductSizeController::class, 'admin_edit'])->name('delivery_size.admin.edit');
    Route::post('/store', [DeliveryProductSizeController::class, 'admin_store'])->name('delivery_size.admin.store');
    Route::post('/update/{id}', [DeliveryProductSizeController::class, 'admin_update'])->name('delivery_size.admin.update');
    Route::get('/destroy/{id}', [DeliveryProductSizeController::class, 'admin_destroy'])->name('delivery_size.admin.destroy');
});

