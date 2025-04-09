<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (! $request->user() || ! $request->user()->hasRole($role)) {
            // You can throw an UnauthorizedException if the user doesn't have the required role
            throw UnauthorizedException::forRoles([$role]);
        }

        return $next($request);
    }
}
