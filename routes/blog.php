<?php

use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\BlogCategoriesController;
use App\Http\Controllers\Admin\BlogTagsController;

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

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/blogs')->group(function () {

    Route::get('/', [BlogsController::class, 'admin_index'])->name('blog.admin.index');
    Route::get('/create', [BlogsController::class, 'admin_create'])->name('blog.admin.create');
    Route::post('/store', [BlogsController::class, 'admin_store'])->name('blog.admin.store');
    Route::get('/edit/{id}', [BlogsController::class, 'admin_edit'])->name('blog.admin.edit');
    Route::post('/update/{id}', [BlogsController::class, 'admin_update'])->name('blog.admin.update');
    Route::get('/delete/{id}', [BlogsController::class, 'admin_destroy'])->name('blog.admin.destroy');
    Route::get('/trash-status/{id}', [BlogsController::class, 'admin_trash_status'])->name('blog.admin.admin_trash_status');
    Route::get('/restore-blog/{id}', [BlogsController::class, 'restore_blog'])->name('blog.admin.restore_blog');
    Route::get('/trashed-blogs', [BlogsController::class, 'trash_list'])->name('blog.admin.trash_list');
    Route::get('/remove_feature_image/{id}', [BlogsController::class, 'remove_feature_image'])->name('blog.admin.remove_feature_image');

    Route::match(['GET', 'POST'], '/categories/list/{id?}', [BlogCategoriesController::class, 'list'])->name('blog_category.admin.list');
    Route::get('/categories/', [BlogCategoriesController::class, 'admin_index'])->name('blog_category.admin.index');
    Route::get('/categories/create', [BlogCategoriesController::class, 'admin_create'])->name('blog_category.admin.create');
    Route::post('/categories/store', [BlogCategoriesController::class, 'admin_store'])->name('blog_category.admin.store');
    Route::get('/categories/edit/{id}', [BlogCategoriesController::class, 'admin_edit'])->name('blog_category.admin.edit');
    Route::post('/categories/update/{id}', [BlogCategoriesController::class, 'admin_update'])->name('blog_category.admin.update');
    Route::get('/categories/delete/{id}', [BlogCategoriesController::class, 'admin_destroy'])->name('blog_category.admin.destroy');
    Route::get('/categories/trash-status/{id}', [BlogCategoriesController::class, 'admin_trash_status'])->name('blog_category.admin.admin_trash_status');
    Route::post('/categories/admin_ajax_add_category', [BlogCategoriesController::class, 'admin_ajax_add_category'])->name('blog_category.admin.admin_ajax_add_category');

    Route::match(['get'], '/categories/moveup/{id}', [BlogCategoriesController::class, 'admin_moveup'])->name('blog_category.admin.categories.admin_moveup');
    Route::match(['get'], '/categories/movedown/{id}', [BlogCategoriesController::class, 'admin_movedown'])->name('blog_category.admin.categories.admin_movedown');

    Route::match(['GET', 'POST'], '/tags/list/{id?}', [BlogTagsController::class, 'list'])->name('blog_tag.admin.list');
    Route::get('/tags/', [BlogTagsController::class, 'admin_index'])->name('blog_tag.admin.index');
    Route::get('/tags/create', [BlogTagsController::class, 'admin_create'])->name('blog_tag.admin.create');
    Route::post('/tags/store', [BlogTagsController::class, 'admin_store'])->name('blog_tag.admin.store');
    Route::get('/tags/edit/{id}', [BlogTagsController::class, 'admin_edit'])->name('blog_tag.admin.edit');
    Route::post('/tags/update/{id}', [BlogTagsController::class, 'admin_update'])->name('blog_tag.admin.update');
    Route::get('/tags/delete/{id}', [BlogTagsController::class, 'admin_destroy'])->name('blog_tag.admin.destroy');

});
