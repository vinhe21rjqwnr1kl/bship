<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ConfigurationsController;
use App\Http\Controllers\Front\BlogsController;
use App\Http\Controllers\Front\HomeController;
use App\Models\Configuration;
use Illuminate\Http\Request;

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

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin')->group(function () {


	/*Route for configurations*/
	Route::match(['get'], '/configurations/index', [ConfigurationsController::class, 'admin_index'])->name('admin.configurations.admin_index');
	Route::match(['get', 'post'], '/configurations/add', [ConfigurationsController::class, 'admin_add'])->name('admin.configurations.admin_add');
	Route::match(['get', 'post'], '/configurations/edit/{id}', [ConfigurationsController::class, 'admin_edit'])->name('admin.configurations.admin_edit');
	Route::match(['get'], '/configurations/delete/{id}', [ConfigurationsController::class, 'admin_delete'])->name('admin.configurations.admin_delete');
	Route::match(['get'], '/configurations/view/{id?}', [ConfigurationsController::class, 'admin_view'])->name('admin.configurations.admin_view');
	Route::match(['get', 'post'], '/configurations/prefix/Reading', [ConfigurationsController::class, 'admin_reading'])->name('admin.configurations.admin_reading');
	Route::match(['get','post'], '/configurations/prefix/Settings', [ConfigurationsController::class, 'admin_settings'])->name('admin.configurations.admin_settings');
	Route::match(['get', 'post'], '/configurations/prefix/{prefix?}', [ConfigurationsController::class, 'admin_prefix'])->name('admin.configurations.admin_prefix');
	Route::match(['get', 'post'], '/configurations/admin_change_theme/{id?}/{value?}', [ConfigurationsController::class, 'admin_change_theme'])->name('admin.configurations.admin_change_theme');
	Route::match(['get'], '/configurations/change/{id}', [ConfigurationsController::class, 'admin_change'])->name('admin.configurations.admin_change');
	Route::match(['get'], '/configurations/moveup/{id}', [ConfigurationsController::class, 'admin_moveup'])->name('admin.configurations.admin_moveup');
	Route::match(['get'], '/configurations/movedown/{id}', [ConfigurationsController::class, 'admin_movedown'])->name('admin.configurations.admin_movedown');
	Route::match(['post'], '/configurations/save_permalink', [ConfigurationsController::class, 'save_permalink'])->name('admin.configurations.save_permalink');
	Route::match(['post'], '/configurations/upload_editor_image', [ConfigurationsController::class, 'upload_editor_image'])->name('admin.configurations.upload_editor_image');
	Route::get('/configurations/remove_image/{id}/{name}', [ConfigurationsController::class, 'remove_config_image'])->name('admin.configurations.remove_config_image');

});

//Route::controller(HomeController::class)->group(function () {
//
//	try {
//		if(Schema::hasTable('configurations'))
//		{
//			$permalink		= Configuration::getConfig('Permalink.settings');
//			$rewritereplace = config('menu.permalink_structure_rewritecode');
//			$rewritecode 	= config('menu.permalink_structure');
//			$link 			= str_replace( $rewritecode, $rewritereplace, $permalink );
//
//			if(empty($link) || Str::contains(URL::current(), 'install'))
//			{
//				$link = '/';
//			}
//
//		    $pageLink = '/{slug}';
//
//		    if(empty($permalink) || Str::contains(URL::current(), 'install'))
//		    {
//		    	$pageLink = '?page_id={page_id?}';
//		    }
//
//		    Route::get('/category/{slug?}', 'blogcategory')->name('permalink.category_action');
//			Route::get('/author/{name?}', 'author')->name('permalink.author_action');
//			Route::get('/tag/{slug?}', 'blogtag')->name('permalink.blogtag_action');
//			Route::get('/search', 'search')->name('permalink.search');
//			Route::get('/{year}/{month?}', 'blogarchive')->name('permalink.archive_action')->where(['year' => '[0-9]{4}+','month' => '[0-9]|[0-9]{2}']);
//			Route::get('/blog', 'blogslist');
//			Route::match(['get','post'],'/contact', 'contact')->name('front.contact');
//
//			Route::match(['get','post'],'/', 'all')->name('permalink.action');
//
//		   	Route::match(['get','post'],$pageLink, 'detail')->name('permalink.page_action');
//			if ($link != '/' || $_GET || $_POST ) {
//		   		Route::match(['get','post'],$link, 'detail')->name('permalink.action');
//			}
//
//		}
//	} catch (Exception $e) {
//
//    }
//
//
//});
