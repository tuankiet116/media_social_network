<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    use ApiResponse;
    public function handle($request, Closure $next, ...$guards)
    {
        dd($guards);
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $this->authenticate($request, $guards);
                return $next($request);
            }

            if ($guard == 'api') {
                return $this->responseJsonForbidden();
            }
        }
        auth()->logout();
        return redirect()->route('user.get_login');
    }
}
