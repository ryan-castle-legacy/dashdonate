<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class api_auth
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
		// Get API Key from request
		$api_key = $request->bearerToken();
		// Get IP Address from request
		$ip_addr = $request->ip();
		// Check that API Key was set
		if (!is_null($api_key)) {
			// Search DB for key
			$key = DB::table('apikeys')->where(['key' => $api_key, 'author_ip' => $ip_addr])->first();
			// Check if result was found
			if ($key) {
				// Add API Key to request
				$request->$api_key = $api_key;
				// Continue with request
				return $next($request);
			}
			// Return with 'Not authorized' error
			return response()->json(['error' => 403, 'message' => 'Unauthorized -> The API key you provided has expired or does not exist. '.$ip_addr.''.$api_key], 403);
		}
		// Return with 'Not authorized' error
		return response()->json(['error' => 403, 'message' => 'Unauthorized - This API requires an API key.'], 403);
    }
}
