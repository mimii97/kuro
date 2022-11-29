<?php
namespace App\Http\Controllers\ValidationsApi\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VotePlansRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'type'=>'required',
             'description'=>'required',
             'num_votes_cond'=>'required|integer',
             'kuro_balance_cond'=>'required|integer',
             'revenue'=>'required',
		];
	}


	protected function onUpdate() {
		return [
             'type'=>'required',
             'description'=>'required',
             'num_votes_cond'=>'required|integer',
             'kuro_balance_cond'=>'required|integer',
             'revenue'=>'required',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	

	public function attributes() {
		return [
             'type'=>trans('admin.type'),
             'description'=>trans('admin.description'),
             'num_votes_cond'=>trans('admin.num_votes_cond'),
             'kuro_balance_cond'=>trans('admin.kuro_balance_cond'),
             'revenue'=>trans('admin.revenue'),
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