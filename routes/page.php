<?php

use App\Http\Controllers\Admin\PagesController;

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


Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/pages')->group(function () {

    Route::match(['get', 'post'], '/', [PagesController::class, 'admin_index'])->name('page.admin.index');
    Route::get('/create', [PagesController::class, 'admin_create'])->name('page.admin.create');
    Route::post('/store', [PagesController::class, 'admin_store'])->name('page.admin.store');
    Route::get('/edit/{id}', [PagesController::class, 'admin_edit'])->name('page.admin.edit');
    Route::post('/update/{id}', [PagesController::class, 'admin_update'])->name('page.admin.update');
    Route::get('/delete/{id}', [PagesController::class, 'admin_destroy'])->name('page.admin.destroy');
    Route::get('/trashed-pages', [PagesController::class, 'trash_list'])->name('page.admin.trash_list');
    Route::get('/restore-page/{id}', [PagesController::class, 'restore_page'])->name('page.admin.restore_page');
    Route::get('/trash-status/{id}', [PagesController::class, 'admin_trash_status'])->name('page.admin.admin_trash_status');
    Route::get('/remove_feature_image/{id}', [PagesController::class, 'remove_feature_image'])->name('page.admin.remove_feature_image');

});