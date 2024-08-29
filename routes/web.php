<?php

use Illuminate\Support\Facades\Route;

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

if(!function_exists('pr')){
    function pr($value){
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
}

Route::get('/', function() {
  return redirect()->route('admin.dashboard');
});


require __DIR__.'/acl.php';
require __DIR__.'/admin.php';
require __DIR__.'/driver.php';
require __DIR__.'/trip.php';
require __DIR__.'/price.php';
require __DIR__.'/customer.php';
require __DIR__.'/booking.php';
require __DIR__.'/fortify.php';
require __DIR__.'/blog.php';
require __DIR__.'/page.php';
require __DIR__.'/menu.php';
require __DIR__.'/tools.php';
require __DIR__.'/configuration.php';
require __DIR__.'/delivery_product_size.php';
require __DIR__.'/delivery_type.php';
require __DIR__.'/log_add_money.php';
require __DIR__.'/orders.php';
require __DIR__.'/news.php';
require __DIR__.'/flash_sale.php';
require __DIR__.'/tourist_destinations.php';

