<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Exception;

class must_be_guest
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
				return Redirect::route('home');
			} else {
				return $next($request);
			}
		} catch (Exception $e) {
			return Redirect::route('home');
		}
    }
}
