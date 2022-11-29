<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\IcoUsersDataTable;
use Carbon\Carbon;
use App\Models\IcoUser;

use App\Http\Controllers\Validations\IcoUsersRequest;


class IcoUsers extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:icousers_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:icousers_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:icousers_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:icousers_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(IcoUsersDataTable $icousers)
            {
               return $icousers->render('admin.icousers.index',['title'=>trans('admin.icousers')]);
            }


            

            public function create()
            {
            	
               return view('admin.icousers.create',['title'=>trans('admin.create')]);
            }

            

            public function store(IcoUsersRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$icousers = IcoUser::create($data); 

			return successResponseJson([
				"message" => trans("admin.added"),
				"data" => $icousers,
			]);
			 }

            

            public function show($id)
            {
        		$icousers =  IcoUser::find($id);
        		return is_null($icousers) || empty($icousers)?
        		backWithError(trans("admin.undefinedRecord"),aurl("icousers")) :
        		view('admin.icousers.show',[
				    'title'=>trans('admin.show'),
					'icousers'=>$icousers
        		]);
            }


            

            public function edit($id)
            {
        		$icousers =  IcoUser::find($id);
        		return is_null($icousers) || empty($icousers)?
        		backWithError(trans("admin.undefinedRecord"),aurl("icousers")) :
        		view('admin.icousers.edit',[
				  'title'=>trans('admin.edit'),
				  'icousers'=>$icousers
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new IcoUsersRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(IcoUsersRequest $request,$id)
            {
              // Check Record Exists
              $icousers =  IcoUser::find($id);
              if(is_null($icousers) || empty($icousers)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("icousers"));
              }
              $data = $this->updateFillableColumns(); 
              IcoUser::where('id',$id)->update($data);

              $icousers = IcoUser::find($id);
              return successResponseJson([
               "message" => trans("admin.updated"),
               "data" => $icousers,
              ]);
			}

            

	public function destroy($id){
		$icousers = IcoUser::find($id);
		if(is_null($icousers) || empty($icousers)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("icousers"));
		}
               
		it()->delete('icouser',$id);
		$icousers->delete();
		return redirectWithSuccess(aurl("icousers"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$icousers = IcoUser::find($id);
				if(is_null($icousers) || empty($icousers)){
					return backWithError(trans('admin.undefinedRecord'),aurl("icousers"));
				}
                    	
				it()->delete('icouser',$id);
				$icousers->delete();
			}
			return redirectWithSuccess(aurl("icousers"),trans('admin.deleted'));
		}else {
			$icousers = IcoUser::find($data);
			if(is_null($icousers) || empty($icousers)){
				return backWithError(trans('admin.undefinedRecord'),aurl("icousers"));
			}
                    
			it()->delete('icouser',$data);
			$icousers->delete();
			return redirectWithSuccess(aurl("icousers"),trans('admin.deleted'));
		}
	}
            
	


}