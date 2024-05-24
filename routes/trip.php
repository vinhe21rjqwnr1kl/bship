<?php

use App\Http\Controllers\Admin\TripController;

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
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin/trip')->group(function () {
    Route::get('/index/{service_id}', [TripController::class, 'admin_index'])->name('trip.admin.index');
    Route::get('/fail', [TripController::class, 'admin_fail'])->name('trip.admin.fail');
    Route::get('/cancel', [TripController::class, 'admin_cancel'])->name('trip.admin.cancel');
    Route::get('/search', [TripController::class, 'admin_search'])->name('trip.admin.search');
    Route::get('/create', [TripController::class, 'admin_create'])->name('trip.admin.create');
    Route::post('/store', [TripController::class, 'admin_store'])->name('trip.admin.store');
    Route::get('/status/{id}', [TripController::class, 'status'])->name('trip.admin.status');
    Route::get('/detail/{service_id}/{go_id}', [TripController::class, 'admin_detail'])->name('trip.admin.detail');


});



Route::prefix('admin/tripp')->group(function () {

    Route::get('/bot', [TripController::class, 'admin_bot'])->name('trip.admin.bot');


});
