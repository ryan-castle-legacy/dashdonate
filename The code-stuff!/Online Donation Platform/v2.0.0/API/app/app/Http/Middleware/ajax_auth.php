<?php

namespace App\Http\Middleware;

use Closure;

class ajax_auth
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
		// List allowed origins
		$origins = array(
			env('FRONTEND_URL'),
		);
		// Check if origin is in allowed origins list
		if (in_array($request->headers->get('origin'), $origins)) {
			// Set header for allowing CORS request
			header('Access-Control-Allow-Origin: '.$request->headers->get('origin'));
			// Continue with request
			return $next($request);
		}
		return response()->json(['error' => 403, 'message' => 'Unauthorized Request'], 403);
    }
}
