<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Exception;
use DB;

class CharityStaffOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
		// Check variable
		$meets_criteria = false;
		// Get charity ID
		$charity_id = @$request->route()->parameter('charity_id');
		// Get charity slug
		$charity_slug = @$request->route()->parameter('charity_slug');
		// Check if charity ID or slug is set
		if ($charity_id || $charity_slug) {
			// Get staff record
			$staff = DB::table('charities_staff')->where(['charity_id' => $charity_id, 'user_id' => Auth::user()->id, 'request_approved' => true])->first();
			// Check if staff role was not found by ID
			if (!$staff) {
				// Get staff record from charity slug
				$staff = DB::table('charities_staff')
					->join('charities', 'charities_staff.charity_id', '=', 'charities.id')
					->select('charities_staff.*')
					->where(['charities.slug' => $charity_slug, 'user_id' => Auth::user()->id, 'request_approved' => true])->first();
			}
			// Check if record was found
			if ($staff) {
				// Get role in middleware
				switch ($role) {
					case 'all': case 'staff':
						$meets_criteria = true;
					break;
					case 'owner':
						if ($staff->is_owner == true) {
							$meets_criteria = true;
						}
					break;
					case 'representative':
						if ($staff->is_representative == true) {
							$meets_criteria = true;
						}
					break;
					case 'administrator':
						if ($staff->role == 'administrator') {
							$meets_criteria = true;
						}
					break;
				}
			}
		}
		// Check if meets criteria
		if ($meets_criteria) {
			return $next($request);
		} else {
			// Send to 401 (unauthorised page)
			return Redirect::route('error-403');
		}
    }
}
