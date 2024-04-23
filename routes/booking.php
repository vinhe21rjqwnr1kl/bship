<?php

use App\Http\Controllers\Admin\BookingController;

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
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin/booking')->group(function () {
    Route::get('/', [BookingController::class, 'admin_order'])->name('booking.admin.order');
    Route::get('/edit/{id}', [BookingController::class, 'admin_edit'])->name('booking.admin.edit');
    Route::post('/update/{id}', [BookingController::class, 'admin_update'])->name('booking.admin.update');
    Route::get('/comment', [BookingController::class, 'admin_comment'])->name('booking.admin.comment');
    Route::get('/commentedit/{id}', [BookingController::class, 'admin_commentedit'])->name('booking.admin.commentedit');
    Route::post('/commentupdate/{id}', [BookingController::class, 'admin_commentupdate'])->name('booking.admin.commentupdate');
    Route::get('/service', [BookingController::class, 'admin_service'])->name('booking.admin.service');
    Route::get('/serviceedit/{id}', [BookingController::class, 'admin_serviceedit'])->name('booking.admin.serviceedit');
    Route::post('/serviceupdate/{id}', [BookingController::class, 'admin_serviceupdate'])->name('booking.admin.serviceupdate'); 
    Route::get('/servicecreate', [BookingController::class, 'admin_servicecreate'])->name('booking.admin.servicecreate');
    Route::post('/servicestore', [BookingController::class, 'admin_servicestore'])->name('booking.admin.servicestore');
    Route::get('/image', [BookingController::class, 'admin_image'])->name('booking.admin.image');
    Route::get('/imageedit/{id}', [BookingController::class, 'admin_imageedit'])->name('booking.admin.imageedit');
    Route::post('/imageupdate/{id}', [BookingController::class, 'admin_imageupdate'])->name('booking.admin.imageupdate'); 
    Route::get('/imagecreate', [BookingController::class, 'admin_imagecreate'])->name('booking.admin.imagecreate');
    Route::post('/imagestore', [BookingController::class, 'admin_imagestore'])->name('booking.admin.imagestore');

    Route::get('/supplier', [BookingController::class, 'admin_supplier'])->name('booking.admin.supplier');
    Route::get('/supplieredit/{id}', [BookingController::class, 'admin_supplieredit'])->name('booking.admin.supplieredit');
    Route::post('/supplierupdate/{id}', [BookingController::class, 'admin_supplierupdate'])->name('booking.admin.supplierupdate'); 
    Route::get('/suppliercreate', [BookingController::class, 'admin_suppliercreate'])->name('booking.admin.suppliercreate');
    Route::post('/supplierstore', [BookingController::class, 'admin_supplierstore'])->name('booking.admin.supplierstore');

});

