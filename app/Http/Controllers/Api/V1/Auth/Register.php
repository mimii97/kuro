<?php
namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationsApi\V1\Auth\RegisterRequest;
use App\Http\Controllers\Validations\UsersRequest;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class Register extends Controller {

	private function auth() {
		return auth()->guard('api');
	}
	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token) {
		return [
			'access_token' => $token,
			'token_type' => 'Bearer',
			'user' => $this->auth()->user(),
		];
	}

	/**
	 * register & Get a JWT via given credentials.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function register(UsersRequest $register) {
		$register = $register->except('lang');
		$register['password'] = bcrypt(request('password'));
		/*$register['email_verified_at'] =null;
		$register['user_name'] =null;
		$register['age'] =null;
		$register['group_id'] =2;*/

		
		$user = User::create($register);
		//$user = $this->jwt->User();
		//return $user();
		
		//$token = Auth::login($user);
		//return $token;
		$credentials = request(['email', 'password']);
		//$user = JWTAuth::parseToken()->authenticate();
		//return auth()->user();
		//$toke =$this->auth()->attempt($credentials);
		//return $this;
		Config::set('auth.providers.users.model', \App\Models\User::class);
		try {
			if (!$token = $this->auth()->attempt($credentials)) {
				return errorResponseJson(['error' => 'Unauthorized', 'message' => trans('auth.failed')]);
			}
		} catch (JWTException $e) {
			return errorResponseJson(['error' => 'Unauthorized', 'message' => 'Could not create token']);
		}
		//$token = "sBVsEDXFH1r2Bm3rAeDtJYYWLIkRPHR4bcORVcJdiTPTX6lphaCMpUwblFwb4KkN";
		return successResponseJson(['data' => $this->respondWithToken($token)]);
	}

}