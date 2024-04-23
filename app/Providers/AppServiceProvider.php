<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        /* dzmenu menu handling */
        $SystemActions = array_merge(config('dzmenu.System.Users'), config('dzmenu.System.Roles'), config('dzmenu.System.Permissions'), config('dzmenu.System.Configurations'), config('dzmenu.System.Module'), config('dzmenu.System.Countries'), config('dzmenu.System.States'), config('dzmenu.System.Cities'));
        $PagesActions = array_merge(config('dzmenu.Page.Pages'));
        $BlogsActions = array_merge(config('dzmenu.Blog.Blogs'), config('dzmenu.Blog.BlogCategories'));
        $MenusActions = array_merge(config('dzmenu.Menu.Menus'), config('dzmenu.Menu.Menus'));
        $MenuItemsActions = array_merge(config('dzmenu.Menu.MenuItems'), config('dzmenu.Menu.MenuItems'));
        
        View::share(compact('SystemActions', 'PagesActions', 'BlogsActions', 'MenusActions', 'MenuItemsActions'));

        
    }
}
