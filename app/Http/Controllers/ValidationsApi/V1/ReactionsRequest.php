<?php
namespace App\Http\Controllers\ValidationsApi\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReactionsRequest extends FormRequest {

	

	public function authorize() {
		return true;
	}

	

	protected function onCreate() {
		return [
             'like'=>'nullable|boolean',
             'dislike'=>'nullable|boolean',
             'user_id'=>'required',
             'blog_id'=>'required',
		];
	}


	protected function onUpdate() {
		return [
             'like'=>'nullable|boolean',
             'dislike'=>'nullable|boolean',
             'user_id'=>'required',
             'blog_id'=>'required',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	

	public function attributes() {
		return [
             'like'=>trans('admin.like'),
             'dislike'=>trans('admin.dislike'),
             'user_id'=>trans('admin.user_id'),
             'blog_id'=>trans('admin.blog_id'),
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