<?php

use App\Http\Controllers\Admin\MenusController;

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

Route::middleware(['auth:sanctum', 'verified'])->prefix('admin/menu')->group(function () {

    Route::match(['get', 'post'], '/index/{id?}', [MenusController::class, 'admin_index'])->name('menu.admin.admin_index');
    Route::post('/create', [MenusController::class, 'admin_create'])->name('menu.admin.admin_create');
    Route::post('/delete', [MenusController::class, 'admin_destroy'])->name('menu.admin.admin_destroy');
    Route::post('/ajax_menu_item_delete', [MenusController::class, 'ajax_menu_item_delete'])->name('menu.admin.ajax_menu_item_delete');
    Route::post('/admin_select_menu/{id?}', [MenusController::class, 'admin_select_menu'])->name('menu.admin.admin_select_menu');
    Route::post('/ajax_add_link', [MenusController::class, 'ajax_add_link'])->name('menu.admin.ajax_add_link');
    Route::post('/ajax_add_page', [MenusController::class, 'ajax_add_page'])->name('menu.admin.ajax_add_page');
    Route::post('/search_menus', [MenusController::class, 'search_menus'])->name('menu.admin.search_menus');

});
