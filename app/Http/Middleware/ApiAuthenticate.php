<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthenticate
{
    use ApiResponse;

    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->check()) {
            return $next($request);
        }
        auth()->logout();
        return $this->responseJsonForbidden();
    }
}
