<?php

namespace App\Http\Middleware;

use Closure;
use Hexadog\ThemesManager\Http\Middleware\ThemeLoader as HexadogThemeLoader;
use Illuminate\Http\Request;

class ThemeLoader extends HexadogThemeLoader
{
    public function handle($request, Closure $next, $theme = 'w3cms/cryptozone')
    {
        $theme = config('Theme.select_theme') ? config('Theme.select_theme') : $theme;
        // Call parent Middleware handle method
        return parent::handle($request, $next, $theme);
    }
}
