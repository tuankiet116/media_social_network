<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthenticate
{
    use ApiResponse;

    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            return $next($request);
        }
        auth('web')->logout();
        return $this->responseJsonForbidden();
    }
}
