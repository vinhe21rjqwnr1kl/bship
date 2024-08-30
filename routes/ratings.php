<?php

use App\Http\Controllers\Admin\RatingsController;

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/ratings')->group(function () {
    Route::get('/', [RatingsController::class, 'index'])->name('admin.ratings.index');

    // Route::get('/create', [RatingsController::class, 'create'])->name('admin.news.create');
    // Route::post('/store', [RatingsController::class, 'store'])->name('admin.news.store');
    // Route::get('/edit/{id}', [RatingsController::class, 'edit'])->name('admin.news.edit');
    // Route::post('/update/{id}', [RatingsController::class, 'update'])->name('admin.news.update');
    Route::delete('/destroy/{id}', [RatingsController::class, 'destroy'])->name('admin.ratings.destroy');
    Route::post('/update-status', [RatingsController::class, 'updateStatus'])->name('update-status');

});