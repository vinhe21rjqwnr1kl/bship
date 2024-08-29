<?php

use App\Http\Controllers\Admin\TouristDestinationsController;

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/tourist-destination')->group(function () {
    Route::get('/', [TouristDestinationsController::class, 'index'])->name('admin.tourist_destinations.index');

    Route::get('/create', [TouristDestinationsController::class, 'create'])->name('admin.tourist_destinations.create');
    Route::post('/store', [TouristDestinationsController::class, 'store'])->name('admin.tourist_destinations.store');
    Route::get('/edit/{id}', [TouristDestinationsController::class, 'edit'])->name('admin.tourist_destinations.edit');
    Route::post('/update/{id}', [TouristDestinationsController::class, 'update'])->name('admin.tourist_destinations.update');
    Route::delete('/destroy/{id}', [TouristDestinationsController::class, 'destroy'])->name('admin.tourist_destinations.destroy');
});
