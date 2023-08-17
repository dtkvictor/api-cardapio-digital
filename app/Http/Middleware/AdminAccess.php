<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiResponse;
use App\Models\Hierarchy;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hierarchy = auth()->user()->hierarchy;
        $hierarchy = Hierarchy::find($hierarchy);
        
        if(!$hierarchy) {
            return ApiResponse::forbidden();
        }
        return $next($request);
    }
}
