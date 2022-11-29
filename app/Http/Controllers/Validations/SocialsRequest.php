<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialsRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'name'=>'',
             'logo'=>'required|image',
             'link'=>'',
             'file'=>'',
		];
	}

	protected function onUpdate() {
		return [
             'name'=>'',
             'logo'=>'required|image',
             'link'=>'',
             'file'=>'',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	

	public function attributes() {
		return [
             'name'=>trans('admin.name'),
             'logo'=>trans('admin.logo'),
             'link'=>trans('admin.link'),
             'file'=>trans('admin.file'),
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