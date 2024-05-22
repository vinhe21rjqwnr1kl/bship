<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AgencysController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\DashboardController;
use \App\Http\Controllers\Admin\PointController;
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


Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->group(function () {
	Route::get('/', [DashboardController::class, 'dashboard']);
	Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin')->group(function () {

	/*Route for users*/
	Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
	Route::get('/users/create', [UsersController::class, 'create'])->name('admin.users.create');
	Route::post('/users/store', [UsersController::class, 'store'])->name('admin.users.store');
	Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
	Route::post('/users/update/{id}', [UsersController::class, 'update'])->name('admin.users.update');
	Route::get('/users/delete/{id}', [UsersController::class, 'destroy'])->name('admin.users.delete');
	Route::post('/users/update-password/{id}', [UsersController::class, 'update_password'])->name('admin.users.update-password');
	Route::post('/users/update-roles/{id}', [UsersController::class, 'update_user_roles'])->name('admin.users.update_user_roles');
	Route::match(['get', 'post'], '/profile', [UsersController::class, 'profile'])->name('admin.users.profile');
	Route::get('user/remove_image/{id}', [UsersController::class, 'remove_user_image'])->name('admin.user.remove_user_image');

	/*Route for Roles*/
	Route::get('/roles', [RolesController::class, 'index'])->name('admin.roles.index');
	Route::get('/roles/create', [RolesController::class, 'create'])->name('admin.roles.create');
	Route::post('/roles/store', [RolesController::class, 'store'])->name('admin.roles.store');
	Route::get('/roles/edit/{id}', [RolesController::class, 'edit'])->name('admin.roles.edit');
	Route::post('/roles/update/{id}', [RolesController::class, 'update'])->name('admin.roles.update');
	Route::get('/roles/delete/{id}', [RolesController::class, 'destroy'])->name('admin.roles.delete');

	Route::get('/agencys', [AgencysController::class, 'index'])->name('admin.agencys.index');
	Route::get('/agencys/create', [AgencysController::class, 'create'])->name('admin.agencys.create');
	Route::post('/agencys/store', [AgencysController::class, 'store'])->name('admin.agencys.store');
	Route::get('/agencys/edit/{id}', [AgencysController::class, 'edit'])->name('admin.agencys.edit');
	Route::post('/agencys/update/{id}', [AgencysController::class, 'update'])->name('admin.agencys.update');


	Route::get('/voucher', [VoucherController::class, 'index'])->name('admin.voucher.index');
	Route::get('/voucher/create', [VoucherController::class, 'create'])->name('admin.voucher.create');
	Route::post('/voucher/store', [VoucherController::class, 'store'])->name('admin.voucher.store');
	Route::get('/voucher/edit/{id}', [VoucherController::class, 'edit'])->name('admin.voucher.edit');
	Route::post('/voucher/update/{id}', [VoucherController::class, 'update'])->name('admin.voucher.update');
	Route::get('/voucher/listused', [VoucherController::class, 'listused'])->name('admin.voucher.listused');


	Route::get('/usersbutl', [UsersController::class, 'indexbutl'])->name('admin.usersbutl.index');
	Route::get('/usersbutl/edit/{id}', [UsersController::class, 'editbutl'])->name('admin.usersbutl.edit');
	Route::post('/usersbutl/update/{id}', [UsersController::class, 'updatebutl'])->name('admin.usersbutl.update');


    Route::get('/user/check-user', [PointController::class, 'checkUser'])->name('admin.point.check-user');
    Route::get('/user/check-user-give-point', [PointController::class, 'checkUserGivePoint'])->name('admin.point.check-user.give-point');
    Route::get('/user/add-points', [PointController::class, 'addPoint'])->name('admin.point.add');
    Route::post('/user/store-add-points', [PointController::class, 'storeAddPoint'])->name('admin.point.add.store');
    Route::get('/user/give-points', [PointController::class, 'givePoint'])->name('admin.point.give');
    Route::post('/user/store-give-points', [PointController::class, 'storeGivePoint'])->name('admin.point.give.store');




});
