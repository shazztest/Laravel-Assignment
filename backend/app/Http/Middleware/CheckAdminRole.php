<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
