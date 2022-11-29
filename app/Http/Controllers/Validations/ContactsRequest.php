<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactsRequest extends FormRequest {


	public function authorize() {
		return true;
	}


	protected function onCreate() {
		return [
             'name'=>'required',
             'email'=>'required|email',
             'subject'=>'required',
             'message'=>'required',
		];
	}

	protected function onUpdate() {
		return [
             'name'=>'required',
             'email'=>'required|email',
             'subject'=>'required',
             'message'=>'required',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	public function attributes() {
		return [
             'name'=>trans('admin.name'),
             'email'=>trans('admin.email'),
             'subject'=>trans('admin.subject'),
             'message'=>trans('admin.message'),
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