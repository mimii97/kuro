<?php
namespace App\Http\Controllers\ValidationsApi\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ICOsRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'image'=>'required|image',
             'description'=>'required',
             'open_date'=>'date_format:Y-m-d h:i:s',
             'status'=>'',
		];
	}


	protected function onUpdate() {
		return [
             'image'=>'required|image',
             'description'=>'required',
             'open_date'=>'date_format:Y-m-d h:i:s',
             'status'=>'',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	

	public function attributes() {
		return [
             'image'=>trans('admin.image'),
             'description'=>trans('admin.description'),
             'open_date'=>trans('admin.open_date'),
             'status'=>trans('admin.status'),
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