<?php
namespace App\Http\Controllers\ValidationsApi\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest {

	
	public function authorize() {
		return true;
	}

	public function rules() {
		return [
			'name' => 'required|alpha',
			'email' => 'required|email|unique:users,email',
			'password' => [
				'required',
				'string', Password::min(6)->mixedCase()->numbers()->symbols()->uncompromised(),
			],
		];
	}

	
	public function attributes() {
		return [
			'name' => trans('admin.name'),
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