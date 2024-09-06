<?php

use App\Http\Controllers\Admin\FoodPriorityController;

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/food_priority')->group(function () {
    Route::get('/', [FoodPriorityController::class, 'index'])->name('admin.food_priority.index');

    Route::get('/create', [FoodPriorityController::class, 'create'])->name('admin.food_priority.create');
    Route::post('/store', [FoodPriorityController::class, 'store'])->name('admin.food_priority.store');
    Route::delete('/destroy/{id}', [FoodPriorityController::class, 'destroy'])->name('admin.food_priority.destroy');
    Route::get('/restaurants/search', [FoodPriorityController::class, 'search'])->name('restaurants.search');
    Route::get('/products/search', [FoodPriorityController::class, 'search'])->name('products.search');




});