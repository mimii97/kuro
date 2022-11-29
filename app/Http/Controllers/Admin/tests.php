<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\testDataTable;
use Carbon\Carbon;
use App\Models\test;

use App\Http\Controllers\Validations\testRequest;


class tests extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:test_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:test_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:test_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:test_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(testDataTable $test)
            {
               return $test->render('admin.test.index',['title'=>trans('admin.test')]);
            }


            

            public function create()
            {
            	
               return view('admin.test.create',['title'=>trans('admin.create')]);
            }

            

            public function store(testRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$test = test::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('test'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$test =  test::find($id);
        		return is_null($test) || empty($test)?
        		backWithError(trans("admin.undefinedRecord"),aurl("test")) :
        		view('admin.test.show',[
				    'title'=>trans('admin.show'),
					'test'=>$test
        		]);
            }


            

            public function edit($id)
            {
        		$test =  test::find($id);
        		return is_null($test) || empty($test)?
        		backWithError(trans("admin.undefinedRecord"),aurl("test")) :
        		view('admin.test.edit',[
				  'title'=>trans('admin.edit'),
				  'test'=>$test
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new testRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(testRequest $request,$id)
            {
              // Check Record Exists
              $test =  test::find($id);
              if(is_null($test) || empty($test)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("test"));
              }
              $data = $this->updateFillableColumns(); 
              test::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('test'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$test = test::find($id);
		if(is_null($test) || empty($test)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("test"));
		}
               
		it()->delete('test',$id);
		$test->delete();
		return redirectWithSuccess(aurl("test"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$test = test::find($id);
				if(is_null($test) || empty($test)){
					return backWithError(trans('admin.undefinedRecord'),aurl("test"));
				}
                    	
				it()->delete('test',$id);
				$test->delete();
			}
			return redirectWithSuccess(aurl("test"),trans('admin.deleted'));
		}else {
			$test = test::find($data);
			if(is_null($test) || empty($test)){
				return backWithError(trans('admin.undefinedRecord'),aurl("test"));
			}
                    
			it()->delete('test',$data);
			$test->delete();
			return redirectWithSuccess(aurl("test"),trans('admin.deleted'));
		}
	}
            

}