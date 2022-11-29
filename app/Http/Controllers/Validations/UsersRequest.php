<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'name'=>'required',
             'email'=>'required',
             'user_name'=>'',
             'age'=>'nullable',
             'group_id'=>'nullable',
             'password'=>'required',
             'email_verified_at'=>'',
             'vote_id'=>'',
             'vote_revenue'=>'',
             'kuro_balance_wallet'=>'',
		];
	}

	protected function onUpdate() {
		return [
             'name'=>'required',
             'email'=>'required',
             'user_name'=>'',
             'age'=>'nullable',
             'group_id'=>'nullable',
             'password'=>'required',
             'email_verified_at'=>'',
             'vote_id'=>'',
             'vote_revenue'=>'',
             'kuro_balance_wallet'=>'',
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
             'user_name'=>trans('admin.user_name'),
             'age'=>trans('admin.age'),
             'group_id'=>trans('admin.group_id'),
             'password'=>trans('admin.password'),
             'email_verified_at'=>trans('admin.email_verified_at'),
             'vote_id'=>trans('admin.vote_id'),
             'vote_revenue'=>trans('admin.vote_revenue'),
             'kuro_balance_wallet'=>trans('admin.kuro_balance_wallet'),
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