<?php

namespace App\Http\Admin\Middleware;

use Closure;

class AdminActionAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeAction = $request->route()->getName();
        return $next($request);
    }
}
