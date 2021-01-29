<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Exception;

class verified_user
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
		try {
			if (Auth::check()) {
				if (Auth::user()->is_email_confirmed == true) {
		        	return $next($request);
				}
				return Redirect::route('verify_email');
			}
		} catch (Exception $e) {
			return Redirect::route('home');
		}
    }
}
