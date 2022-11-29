<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminGroupsRequest extends FormRequest {

	
	public function authorize() {
		return true;
	}

	
	protected function onCreate() {
		return [
             'group_name'=>'required|string',
		];
	}

	protected function onUpdate() {
		return [
             'group_name'=>'required|string',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	
	public function attributes() {
		return [
             'group_name'=>trans('admin.group_name'),
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