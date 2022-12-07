<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            $user = Auth::guard($guard)->user();
            if (Auth::guard($guard)->check() ) {
                if ($user->active == ACCOUNT_ACTIVE) {
                    return redirect(RouteServiceProvider::HOME);
                } else if ($request->route()->getName() !== "user.get_setting" && $request->route()->getName() !== "user.post_setting"){
                    return redirect()->route('user.get_setting');
                }
            }
        }
        
        return $next($request);
    }
}
