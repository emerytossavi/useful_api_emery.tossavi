<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((Auth('auth:sanctum')->user()->id != null)){

            return $next($request);
        }else{
            return response()->json(
                [
                    "error" => "Module inactive. Please activate this module to use it."
                ],
                403
            );
            // return abort()
        }
    }
}
