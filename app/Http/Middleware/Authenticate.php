<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check if request is for Super Admin
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('super_admin.login');
        }

        // Check if request is for a Store Admin (Multi-Shop)
        if ($shop = $request->route('shop')) {
            return route('admin.login', ['shop' => $shop]);
        }

        // Default fallback (If nothing matches)
        return route('login');
    }
}
