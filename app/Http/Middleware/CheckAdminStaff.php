<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check()){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $request->user();
        if ($user->role_id !== 1 && $user->role_id !== 2) {
            return response()->json(['message' => 'Permission denied'], 403);
        }

        return $next($request);
    }
}
