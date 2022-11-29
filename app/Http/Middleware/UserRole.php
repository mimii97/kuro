<?php

namespace App\Http\Middleware;

use Closure;

class UserRole {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $role) {
		//dd($role);
		//dd(auth()->user()->role());
		//dd(admin()->user()->role($role));
		if (auth()->user()){
			if (!auth()->user()->role($role)) {
				return redirect(url('need/permission'));
			}
		}
		/*if (auth()->user()){
			if (!auth()->user()->role($role)) {
				return redirect(aurl('need/permission'));
			}
		}*/
		return $next($request);
	}
}
