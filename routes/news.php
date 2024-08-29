<?php

use App\Http\Controllers\Admin\NewsController;

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/news')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('admin.news.index');

    Route::get('/create', [NewsController::class, 'create'])->name('admin.news.create');
    Route::post('/store', [NewsController::class, 'store'])->name('admin.news.store');
    Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('admin.news.edit');
    Route::post('/update/{id}', [NewsController::class, 'update'])->name('admin.news.update');
    Route::delete('/destroy/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');
});
