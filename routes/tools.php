<?php

use App\Http\Controllers\Admin\ToolsController;
use App\Http\Controllers\Admin\ThemesController;

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

Route::middleware(['auth:sanctum', 'verified'])->prefix('admin/tools')->group(function () {

    Route::match(['get', 'post'], '/export', [ToolsController::class, 'export'])->name('tools.admin.export');
    Route::match(['get', 'post'], '/import', [ToolsController::class, 'import'])->name('tools.admin.import');
});

Route::middleware(['auth:sanctum', 'verified'])->prefix('admin/themes')->group(function () {
    Route::match(['get', 'post'], '/index', [ThemesController::class, 'index'])->name('themes.admin.index');
    Route::match(['post'], '/import_theme', [ThemesController::class, 'import_theme'])->name('themes.admin.import_theme');
});

/* ============================== Use this route for themes preview images ============================== */
Route::get('/themes/{vendor}/{theme}/{file}', function($vendor, $theme, $file){
    $path = base_path() . '/themes/' . $vendor.'/'.$theme.'/'.$file;

    if(File::exists($path)) {
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    return false;
})->name('get_file');
/* ============================== Use this route for themes preview images ============================== */