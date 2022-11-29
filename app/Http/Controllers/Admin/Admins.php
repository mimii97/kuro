<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\AdminsRequest;
use App\Models\Admin;



class Admins extends Controller {

	public function __construct() {

		$this->middleware('AdminRole:admins_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:admins_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:admins_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:admins_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



	public function index(AdminsDataTable $admins) {
		return $admins->render('admin.admins.index', ['title' => trans('admin.admins')]);
	}



	public function create() {
		return view('admin.admins.create', ['title' => trans('admin.create')]);
	}



	public function store(AdminsRequest $request) {
		$data = $request->except("_token", "_method");
		if (request()->hasFile('photo_profile')) {
			$data['photo_profile'] = it()->upload('photo_profile', 'admins');
		} else {
			$data['photo_profile'] = "";
		}

		$data['password'] = bcrypt(request('password'));

		Admin::create($data);
		return redirectWithSuccess(aurl('admins'), trans('admin.added'));
	}



	public function show($id) {
		$admins = Admin::find($id);
		return is_null($admins) || empty($admins) ?
		backWithError(trans("admin.undefinedRecord")) :
		view('admin.admins.show', [
			'title' => trans('admin.show'),
			'admins' => $admins,
		]);
	}



	public function edit($id) {
		$admins = Admin::find($id);
		return is_null($admins) || empty($admins) ?
		backWithError(trans("admin.undefinedRecord")) :
		view('admin.admins.edit', [
			'title' => trans('admin.edit'),
			'admins' => $admins,
		]);
	}



	public function updateFillableColumns() {
		$fillableCols = [];
		foreach (array_keys((new AdminsRequest)->attributes()) as $fillableUpdate) {
			if (!is_null(request($fillableUpdate))) {
				$fillableCols[$fillableUpdate] = request($fillableUpdate);
			}
		}
		return $fillableCols;
	}

	public function update(AdminsRequest $request, $id) {
		// Check Record Exists
		$admins = Admin::find($id);
		if (is_null($admins) || empty($admins)) {
			return backWithError(trans("admin.undefinedRecord"));
		}
		$data = $this->updateFillableColumns();
		if (!empty(request('password'))) {
			$data['password'] = bcrypt(request('password'));
		}

		if (request()->hasFile('photo_profile')) {
			it()->delete($admins->photo_profile);
			$data['photo_profile'] = it()->upload('photo_profile', 'admins');
		}
		Admin::where('id', $id)->update($data);
		return redirectWithSuccess(aurl('admins'), trans('admin.updated'));
	}



	public function destroy($id) {
		$admins = Admin::find($id);
		if (is_null($admins) || empty($admins)) {
			return backWithError(trans('admin.undefinedRecord'));
		}
		if (!empty($admins->photo_profile)) {
			it()->delete($admins->photo_profile);
		}

		$admins->delete();
		return backWithSuccess(trans('admin.deleted'));

	}

	public function multi_delete() {
		$data = request('selected_data');
		if (is_array($data)) {
			foreach ($data as $id) {
				$admins = Admin::find($id);
				if (is_null($admins) || empty($admins)) {
					return backWithError(trans('admin.undefinedRecord'));
				}
				if (!empty($admins->photo_profile)) {
					it()->delete($admins->photo_profile);
				}

				$admins->delete();

			}
			return backWithSuccess(trans('admin.deleted'));
		} else {
			$admins = Admin::find($data);
			if (is_null($admins) || empty($admins)) {
				return backWithError(trans('admin.undefinedRecord'));
			}

			if (!empty($admins->photo_profile)) {
				it()->delete($admins->photo_profile);
			}

			$admins->delete();
			return backWithSuccess(trans('admin.deleted'));
		}
	}

}