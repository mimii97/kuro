<?php
namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationsApi\V1\Auth\ChangePasswordRequest;
use App\Http\Controllers\ValidationsApi\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Config;

class AuthAndLogin extends Controller {

	
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}

	private function auth() {
		return auth()->guard('api');
	}
	
	protected function respondWithToken($token) {
		return [
			'access_token' => $token,
			'token_type' => 'Bearer',
			'expires_in' => $this->auth()->factory()->getTTL() * 60,
			'user' => $this->auth()->user(),
		];
	}

	
	public function me() {
		return successResponseJson(['data' => $this->auth()->user()]);
	}

	
	public function logout() {
		$this->auth()->logout();
		return successResponseJson(['message' => 'Successfully logged out']);
	}

	
	public function refresh() {
		return successResponseJson(['data' => $this->respondWithToken($this->auth()->refresh())]);
	}

	public function account() {
		return successResponseJson(['data' => $this->auth()->user()]);
	}

	/**
	 * Get a JWT via given credentials.
	 * Login Auth
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(LoginRequest $login) {
		Config::set('auth.model', 'App\Models\User');
		Config::set('auth.table', 'users');
		$credentials = request(['email', 'password']);
		//return ($credentials);
		try {
			if (!$token = $this->auth()->attempt($credentials)) {
				return errorResponseJson(['error' => 'Unauthorized', 'message' => trans('auth.failed')]);
			}
		} catch (JWTException $e) {
			return errorResponseJson(['error' => 'Unauthorized', 'message' => 'Could not create token']);
		}

		return successResponseJson(['data' => $this->respondWithToken($token)]);
	}

	/**
	 * change Password Method
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function change_password(ChangePasswordRequest $changepassword) {
		User::where('id', $this->auth()->user()->id)->update([
			'password' => bcrypt(request('new_password')),
		]);
		return successResponseJson([
			'message' => trans('main.password_changed'),
		]);
	}

}