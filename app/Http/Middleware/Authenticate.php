<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $prefix = request()->route()->getPrefix();

            if(!empty($prefix) && str_contains($prefix, 'admin')) {
                return url('admin/login');
            } else {
                return route('login');
            }
        }
    }
}
