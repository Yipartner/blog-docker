<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware extends BaseEncrypter
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guest())
            return back();
        if (!Auth::user()->is_admin){
            return back();
        }
        return $next($request);
    }
}