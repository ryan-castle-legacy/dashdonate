<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Exception;
use DB;

class verified_charity
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
			// Get charity ID
			$charity_id = @$request->route()->parameter('charity_id');
			// Get charity slug
			$charity_slug = @$request->route()->parameter('charity_slug');
			// Find charity record
			$charity = DB::table('charities')->where(['id' => $charity_id])->first();
			// Check if charity was not found with ID
			if (!$charity) {
				$charity = DB::table('charities')->where(['slug' => $charity_slug])->first();
			}
			// Check if charity was not found
			if (!$charity) {
				// Send to home
				return Redirect::route('home');
			}
			// Get charity representative
			$representative = DB::table('charities_staff')->where(['charity_id' => $charity->id, 'is_representative' => true, 'request_approved' => true])->first();
			// Check if there is a representative setup
			if ($representative) {
				// There is a representative for the charity, so it is 'verified'
				return $next($request);
			} else {
				// Send user to the page to setup a representative
				return Redirect::route('charities-onboarding-confirm_details', ['charity_slug' => $charity->slug]);
			}
		} catch (Exception $e) {
			// Send to home
			return Redirect::route('home');
		}
    }




}
