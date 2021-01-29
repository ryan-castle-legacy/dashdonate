<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Request;
use Auth;
use Redirect;
use Exception;

class AJAX
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
			'ec2-x-x-x-x.eu-west-2.compute.amazonaws.com',
			'dashdonate.org',
		);
		// Check if origin is in allowed origins list
		if (in_array(Request::header('host'), $origins)) {
			// Set header for allowing CORS request
			header('Access-Control-Allow-Origin: '.Request::header('host'));
			// Continue with request
			return $next($request);
		}
		return response()->json(['error' => 403, 'message' => 'Unauthorized Request - '.$request->headers->get('origin')], 403);
    }

}
