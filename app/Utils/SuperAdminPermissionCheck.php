<?php

namespace App\Utils;

use Illuminate\Support\Facades\Auth;

class SuperAdminPermissionCheck
{
    public static function isAdmin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['Super Admin', 'Đại lý'])) {
                return true;
            }
        }

        return false;
    }
}
