<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Request;
use Auth;
use Redirect;
use Exception;

class ajax_widget
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
		// Set header for allowing CORS request
		header('Access-Control-Allow-Origin: *');
		// Continue with request
		return $next($request);
    }

}
