<?php

use App\Http\Controllers\Admin\FlashSaleController;

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/flash-sale')->group(function () {
//    Route::get('/get-discounts', [FlashSaleController::class, 'getDiscounts'])->name('admin.flash_sale.get_discounts');
    Route::get('/', [FlashSaleController::class, 'index'])->name('admin.flash_sale.index');
    Route::get('/create', [FlashSaleController::class, 'create'])->name('admin.flash_sale.create');
    Route::post('/store', [FlashSaleController::class, 'store'])->name('admin.flash_sale.store');
    Route::get('/edit/{id}', [FlashSaleController::class, 'edit'])->name('admin.flash_sale.edit');
    Route::put('/update/{id}', [FlashSaleController::class, 'update'])->name('admin.flash_sale.update');
    Route::delete('/destroy/{id}', [FlashSaleController::class, 'destroy'])->name('admin.flash_sale.destroy');

    Route::prefix('golden-hours')->group(function () {
        Route::get('/', [FlashSaleController::class, 'indexGoldenHours'])->name('admin.flash_sale.golden_hours');
        Route::get('/create', [FlashSaleController::class, 'createGoldenHours'])->name('admin.flash_sale.golden_hours.create');
        Route::post('/store', [FlashSaleController::class, 'storeGoldenHours'])->name('admin.flash_sale.golden_hours.store');
        Route::get('/edit/{id}', [FlashSaleController::class, 'editGoldenHours'])->name('admin.flash_sale.golden_hours.edit');
        Route::put('/update/{id}', [FlashSaleController::class, 'updateGoldenHours'])->name('admin.flash_sale.golden_hours.update');
        Route::delete('/destroy/{id}', [FlashSaleController::class, 'destroyGoldenHours'])->name('admin.flash_sale.golden_hours.destroy');
    });

    Route::get('restaurants', [FlashSaleController::class, 'restaurantList'])->name('admin.flash_sale.restaurant.list');

});
