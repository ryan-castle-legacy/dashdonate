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
				// Check if user's email needs confirmed
				if (Auth::user()->is_email_confirmed == true) {
					// Check if user needs to reset their password
					if (Auth::user()->needs_password_reset == true) {
						// Redirect to reset password
						return Redirect::route('set_user_password');
					}
					// Resume as usual
		        	return $next($request);
				}
				// Redirect to confirm email address
				return Redirect::route('verify_email');
			}
		} catch (Exception $e) {
			return Redirect::route('home');
		}
    }
}
