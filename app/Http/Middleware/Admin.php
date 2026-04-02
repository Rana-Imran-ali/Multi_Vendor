<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     * Ensures the authenticated Sanctum user has the 'admin' role.
     * Returns a JSON error (never a redirect) to keep API contract clean.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthenticated. Please log in.',
            ], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Forbidden. Admin access required.',
            ], 403);
        }

        return $next($request);
    }
}
