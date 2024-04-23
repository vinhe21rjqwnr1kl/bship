<?php

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

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PermissionsController;

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin')->group(function () {
	
	/*Route for permissions*/
	
	Route::get('/permissions', [PermissionsController::class, 'index'])->name('admin.permissions.index');
	Route::get('/permissions/roles-permissions', [PermissionsController::class, 'roles_permissions'])->name('admin.permissions.roles_permissions');
	Route::get('/permissions/role-permissions/{id}', [PermissionsController::class, 'role_permissions'])->name('admin.permissions.role_permissions');
	Route::get('/permissions/user-permissions', [PermissionsController::class, 'user_permissions'])->name('admin.permissions.user_permissions');
	Route::get('/permissions/manage-user-permissions/{id}', [PermissionsController::class, 'manage_user_permissions'])->name('admin.permissions.manage_user_permissions');
	Route::get('/permissions/manage-role-all-permissions/{id}', [PermissionsController::class, 'manage_role_all_permissions'])->name('admin.permissions.manage-role-all-permissions');
	Route::get('/permissions/manage-role-permission/{role_id}/{permission_id}', [PermissionsController::class, 'manage_role_permission'])->name('admin.permissions.manage-role-permission');
	Route::get('/permissions/manage-user-permission/{user_id}/{permission_id}', [PermissionsController::class, 'manage_user_permission'])->name('admin.permissions.manage-user-permission');
	Route::get('/permissions/delete-user-permission/{user_id}/{permission_id}', [PermissionsController::class, 'delete_user_permission'])->name('admin.permissions.delete-user-permission');
	Route::get('/permissions/remove-user-all-permission/{user_id}', [PermissionsController::class, 'remove_user_all_permission'])->name('admin.permissions.remove_user_all_permission');

	Route::get('/permissions/temp_permissions', [PermissionsController::class, 'temp_permissions'])->name('admin.permissions.temp_permissions');
	Route::get('/permissions/generate_permissions', [PermissionsController::class, 'generate_permissions'])->name('admin.permissions.generate_permissions');
	Route::get('/permissions/add_to_permissions', [PermissionsController::class, 'add_to_permissions'])->name('admin.permissions.add_to_permissions');

	Route::post('/permissions/permission_by_action', [PermissionsController::class, 'permission_by_action'])->name('admin.permissions.permission_by_action');
	Route::post('/permissions/get_users_by_role', [PermissionsController::class, 'get_users_by_role'])->name('admin.permissions.get_users_by_role');
	Route::post('/permissions/get_permission_by_user', [PermissionsController::class, 'get_permission_by_user'])->name('admin.permissions.get_permission_by_user');
});