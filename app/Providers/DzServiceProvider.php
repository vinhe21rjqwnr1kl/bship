<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Configuration;

class DzServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helper/DzHelper.php';
		require_once app_path() . '/Helper/HelpDesk.php';
        require_once app_path() . '/Helper/Acl.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->config_handler();
    }

    /*
    * Load all configuration data
    */
    private function config_handler()
    {
        try {
            \DB::connection()->getPdo();
            
            if(\Schema::hasTable('configurations')) 
            {
                $configuration = new Configuration();
                $configuration->init();
            }

        } catch (\Exception $e) {
        }
    }
}
