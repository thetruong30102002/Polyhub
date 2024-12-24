<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsEmployee
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->user_type == 'employee' || Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'supper')) {
            return $next($request);
        }

        return redirect('/');
    }
}