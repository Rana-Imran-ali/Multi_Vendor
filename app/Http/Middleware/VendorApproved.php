<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

       if (auth()->user()->role === 'vendor' && !auth()->user()->is_approved) {
        return response()->json(['message' => 'Vendor not approved'], 403);
    }
        return $next($request);
    }
}
