<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAutenticated {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		//dd(Auth::guard($guard)->check());
		//dd(1);
		if ($guard == 'admin'){
			if (Auth::guard($guard)->check()) {
				return $next($request);
			}
			return redirect(aurl('login'));
		}
		
		if ($guard == 'web'){
			if (Auth::guard($guard)->check()) {
				
				return $next($request);
			}
			return redirect(url('login'));
		}
	}
}
