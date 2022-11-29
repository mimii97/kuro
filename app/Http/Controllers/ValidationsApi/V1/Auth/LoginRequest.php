<?php
namespace App\Http\Controllers\ValidationsApi\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest {

	
	public function authorize() {
		return true;
	}

	public function rules() {
		return [
			'email' => 'required|email',
			'password' => [
				'required',
				'string', Password::min(6),
			],
		];
	}

	
	public function attributes() {
		return [
			'email' => trans('admin.email'),
			'password' => trans('admin.password'),
		];
	}

	
	public function response(array $errors) {
		return $this->ajax() || $this->wantsJson() ?
		response([
			'status' => false,
			'StatusCode' => 422,
			'StatusType' => 'Unprocessable',
			'errors' => $errors,
		], 422) :
		back()->withErrors($errors)->withInput(); // Redirect back
	}

}