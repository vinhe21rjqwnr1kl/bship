<?php

use App\Http\Controllers\Admin\PriceController;

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
Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/price')->group(function () {
    //giá theo kilomet
    Route::get('/km', [PriceController::class, 'admin_km'])->name('price.admin.km');
    Route::get('/kmedit/{id}', [PriceController::class, 'admin_kmedit'])->name('price.admin.kmedit');
    Route::get('/kmdeletet/{id}', [PriceController::class, 'admin_kmdelete'])->name('price.admin.kmdelete');
    Route::get('/kmcreate/', [PriceController::class, 'admin_kmcreate'])->name('price.admin.kmcreate');
    Route::post('/kmstore/', [PriceController::class, 'admin_kmstore'])->name('price.admin.kmstore');
    Route::post('/kmupdate/{id}', [PriceController::class, 'admin_kmupdate'])->name('price.admin.kmupdate');
    //giá theo thời gian
    Route::get('time', [PriceController::class, 'admin_time'])->name('price.admin.time');
    Route::get('/timeedit/{id}', [PriceController::class, 'admin_timeedit'])->name('price.admin.timeedit');
    Route::get('/timedeletet/{id}', [PriceController::class, 'admin_timedelete'])->name('price.admin.timedelete');
    Route::get('/timecreate/', [PriceController::class, 'admin_timecreate'])->name('price.admin.timecreate');
    Route::post('/timestore/', [PriceController::class, 'admin_timestore'])->name('price.admin.timestore');
    Route::post('/timeupdate/{id}', [PriceController::class, 'admin_timeupdate'])->name('price.admin.timeupdate');
    //giá theo thành phố
    Route::get('/city', [PriceController::class, 'admin_city'])->name('price.admin.city');
    Route::get('/cityedit/{id}', [PriceController::class, 'admin_cityedit'])->name('price.admin.cityedit');
    Route::get('/cityedeletet/{id}', [PriceController::class, 'admin_citydelete'])->name('price.admin.citydelete');
    Route::get('/citycreate/', [PriceController::class, 'admin_citycreate'])->name('price.admin.citycreate');
    Route::post('/citystore/', [PriceController::class, 'admin_citystore'])->name('price.admin.citystore');
    Route::post('/cityupdate/{id}', [PriceController::class, 'admin_cityupdate'])->name('price.admin.cityupdate');
    //giá theo bảo hiểm
    Route::get('/ext', [PriceController::class, 'admin_ext'])->name('price.admin.ext');
    Route::get('/extedit/{id}', [PriceController::class, 'admin_extedit'])->name('price.admin.extedit');
    Route::get('/extdeletet/{id}', [PriceController::class, 'admin_extdelete'])->name('price.admin.extdelete');
    Route::get('/extcreate/', [PriceController::class, 'admin_extcreate'])->name('price.admin.extcreate');
    Route::post('/extstore/', [PriceController::class, 'admin_extstore'])->name('price.admin.extstore');
    Route::post('/extupdate/{id}', [PriceController::class, 'admin_extupdate'])->name('price.admin.extupdate');


// cài đặt dịch vụ cha
    Route::get('/service', [PriceController::class, 'admin_service'])->name('price.admin.service');
    Route::get('/serviceedit/{id}', [PriceController::class, 'admin_serviceedit'])->name('price.admin.serviceedit');
    Route::post('/serviceupdate/{id}', [PriceController::class, 'admin_serviceupdate'])->name('price.admin.serviceupdate');
// cài đặt dịch vụ con
    Route::get('/servicesub', [PriceController::class, 'admin_servicesub'])->name('price.admin.servicesub');
    Route::get('/servicesubedit/{id}', [PriceController::class, 'admin_servicesubedit'])->name('price.admin.servicesubedit');
    Route::post('/servicesubupdate/{id}', [PriceController::class, 'admin_servicesubupdate'])->name('price.admin.servicesubupdate');

    // cài đặt nhóm  dịch  vụ  show  ở  trang  chủ  con
    Route::get('/group', [PriceController::class, 'admin_group'])->name('price.admin.group');
    Route::get('/groupedit/{id}', [PriceController::class, 'admin_groupedit'])->name('price.admin.groupedit');
    Route::post('/groupupdate/{id}', [PriceController::class, 'admin_groupupdate'])->name('price.admin.groupupdate');


    //thêm dịch  vụ  vào  nhóm  trong  trang  chủ  con
    Route::get('/gservice', [PriceController::class, 'admin_gservice'])->name('price.admin.gservice');
    Route::get('/gservicedelete/{id}', [PriceController::class, 'admin_gservicedelete'])->name('price.admin.gservicedelete');
    Route::get('/gservicecreate/', [PriceController::class, 'admin_gservicecreate'])->name('price.admin.gservicecreate');
    Route::post('/gservicestore/', [PriceController::class, 'admin_gservicestore'])->name('price.admin.gservicestore');
    Route::get('/detailservice', [PriceController::class, 'admin_detailservice'])->name('price.admin.detailservice');
    Route::get('/detailserviceedit/{id}', [PriceController::class, 'admin_sdetailserviceedit'])->name('price.admin.detailserviceedit');
    Route::get('/detailservicstatuseedit/{id}', [PriceController::class, 'admin_detailservicstatuseedit'])->name('price.admin.detailservicstatuseedit');

    //option của dich vu
    Route::get('/option', [PriceController::class, 'admin_option'])->name('price.admin.option');
    Route::get('/optionedit/{id}', [PriceController::class, 'admin_optionedit'])->name('price.admin.optionedit');
    Route::get('/optiondelete/{id}', [PriceController::class, 'admin_optiondelete'])->name('price.admin.optiondelete');
    Route::get('/optioncreate/', [PriceController::class, 'admin_optioncreate'])->name('price.admin.optioncreate');
    Route::post('/optionstore/', [PriceController::class, 'admin_optionstore'])->name('price.admin.optionstore');
    Route::post('/optionupdate/{id}', [PriceController::class, 'admin_optionupdate'])->name('price.admin.optionupdate');


    Route::get('/cache', [PriceController::class, 'admin_cache'])->name('price.admin.cache');


    Route::get('/agencyservice', [PriceController::class, 'admin_agencyservice'])->name('price.admin.agencyservice');
    Route::get('/agencyservicecreate', [PriceController::class, 'admin_agencyservicecreate'])->name('price.admin.agencyservicecreate');
    Route::get('/agencyservicedel/{id}', [PriceController::class, 'admin_agencyservicedel'])->name('price.admin.agencyservicedel');
    Route::post('/agencyservicestore/', [PriceController::class, 'admin_agencyservicestore'])->name('price.admin.agencyservicestore');

    Route::get('/cityservice', [PriceController::class, 'admin_cityservice'])->name('price.admin.cityservice');
    Route::get('/cityserviceedit/{id}', [PriceController::class, 'admin_cityserviceedit'])->name('price.admin.cityserviceedit');
    Route::get('/cityservicecreate', [PriceController::class, 'admin_cityservicecreate'])->name('price.admin.cityservicecreate');
    Route::get('/cityservicedel/{id}', [PriceController::class, 'admin_cityserviceedel'])->name('price.admin.cityservicedel');
    Route::post('/cityservicestore/', [PriceController::class, 'admin_cityservicestore'])->name('price.admin.cityservicestore');
    Route::post('/cityserviceupdate/{id}', [PriceController::class, 'admin_cityserviceupdate'])->name('price.admin.cityserviceupdate');

});
