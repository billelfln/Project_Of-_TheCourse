<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   // 👈 add this
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        if (!Auth::check() ||  !in_array(Auth::user()->role,$roles)) {
            return abort(403) ;// redirect if not admin
        }

        return $next($request);
    }
}
