<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BFOTPlansRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'type'=>'required',
             'description'=>'required',
             'num_of_refs_cond'=>'required|integer',
             'revenue'=>'required',
			 'kuro_balance_cond' => 'required',
		];
	}

	protected function onUpdate() {
		return [
             'type'=>'required',
             'description'=>'required',
             'num_of_refs_cond'=>'required|integer',
             'revenue'=>'required',
			 'kuro_balance_cond' => 'required',

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
             'num_of_refs_cond'=>trans('admin.num_of_refs_cond'),
             'revenue'=>trans('admin.revenue'),
			 'kuro_balance_cond' => trans('admin.kuro_balance_cond'),
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