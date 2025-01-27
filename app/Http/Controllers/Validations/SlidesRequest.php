<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SlidesRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'image'=>'required|image',
             'page_id'=>'',
		];
	}

	protected function onUpdate() {
		return [
             'image'=>'image',
             'page_id'=>'',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	

	public function attributes() {
		return [
             'image'=>trans('admin.image'),
             'page_id'=>trans('admin.page_id'),
             'page_id'=>trans('admin.page_id'),
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