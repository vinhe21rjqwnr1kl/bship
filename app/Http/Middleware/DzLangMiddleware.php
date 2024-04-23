<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class DzLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $availableLangs = config('constants.available_langs');
        $setLang = !empty($_COOKIE['w3cms_locale']) ? $_COOKIE['w3cms_locale'] : config('Site.w3cms_locale');

        if(array_key_exists($setLang, $availableLangs)){
            app()->setLocale($setLang);
        }

        return $next($request);
    }
}
