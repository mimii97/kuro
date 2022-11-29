<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IcoUsersRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'amount'=>'required',
             'status'=>'required|in:joined,pending',
             'purchase_method'=>'',
             'user_id'=>'',
             'i_c_o_id'=>'',
		];
	}

	protected function onUpdate() {
		return [
             'amount'=>'required',
             'status'=>'required|in:joined,pending',
             'purchase_method'=>'',
             'user_id'=>'',
             'i_c_o_id'=>'',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	

	public function attributes() {
		return [
             'amount'=>trans('admin.amount'),
             'status'=>trans('admin.status'),
             'purchase_method'=>trans('admin.purchase_method'),
             'user_id'=>trans('admin.user_id'),
             'i_c_o_id'=>trans('admin.i_c_o_id'),
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