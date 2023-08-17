<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FinalizeRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $details = auth()->user()->details;
        $address = auth()->user()->address;

        if(!$details) return ApiResponse::unauthorized();
        if(!$address) return ApiResponse::unauthorized();
        
        return $next($request);
    }
}
