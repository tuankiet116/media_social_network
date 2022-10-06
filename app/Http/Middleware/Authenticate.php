<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        forEach($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $this->authenticate($request, $guards);
                return $next($request);
            }
        }
        auth()->logout();
        return redirect()->route('user.get_login');
    }
}
