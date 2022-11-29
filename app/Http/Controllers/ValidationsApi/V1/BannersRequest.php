<?php
namespace App\Http\Controllers\ValidationsApi\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BannersRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'description'=>'',
             'image'=>'required|image',
		];
	}


	protected function onUpdate() {
		return [
             'description'=>'',
             'image'=>'required|image',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	

	public function attributes() {
		return [
             'description'=>trans('admin.description'),
             'image'=>trans('admin.image'),
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