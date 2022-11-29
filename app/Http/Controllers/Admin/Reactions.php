<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\ReactionsDataTable;
use Carbon\Carbon;
use App\Models\Reaction;

use App\Http\Controllers\Validations\ReactionsRequest;


class Reactions extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:reactions_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:reactions_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:reactions_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:reactions_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(ReactionsDataTable $reactions)
            {
               return $reactions->render('admin.reactions.index',['title'=>trans('admin.reactions')]);
            }


            

            public function create()
            {
            	
               return view('admin.reactions.create',['title'=>trans('admin.create')]);
            }

            

            public function store(ReactionsRequest $request)
            {
                $data = $request->except("_token", "_method");
            		$reactions = Reaction::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('reactions'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$reactions =  Reaction::find($id);
        		return is_null($reactions) || empty($reactions)?
        		backWithError(trans("admin.undefinedRecord"),aurl("reactions")) :
        		view('admin.reactions.show',[
				    'title'=>trans('admin.show'),
					'reactions'=>$reactions
        		]);
            }


            

            public function edit($id)
            {
        		$reactions =  Reaction::find($id);
        		return is_null($reactions) || empty($reactions)?
        		backWithError(trans("admin.undefinedRecord"),aurl("reactions")) :
        		view('admin.reactions.edit',[
				  'title'=>trans('admin.edit'),
				  'reactions'=>$reactions
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new ReactionsRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(ReactionsRequest $request,$id)
            {
              // Check Record Exists
              $reactions =  Reaction::find($id);
              if(is_null($reactions) || empty($reactions)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("reactions"));
              }
              $data = $this->updateFillableColumns(); 
              Reaction::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('reactions'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$reactions = Reaction::find($id);
		if(is_null($reactions) || empty($reactions)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("reactions"));
		}
               
		it()->delete('reaction',$id);
		$reactions->delete();
		return redirectWithSuccess(aurl("reactions"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$reactions = Reaction::find($id);
				if(is_null($reactions) || empty($reactions)){
					return backWithError(trans('admin.undefinedRecord'),aurl("reactions"));
				}
                    	
				it()->delete('reaction',$id);
				$reactions->delete();
			}
			return redirectWithSuccess(aurl("reactions"),trans('admin.deleted'));
		}else {
			$reactions = Reaction::find($data);
			if(is_null($reactions) || empty($reactions)){
				return backWithError(trans('admin.undefinedRecord'),aurl("reactions"));
			}
                    
			it()->delete('reaction',$data);
			$reactions->delete();
			return redirectWithSuccess(aurl("reactions"),trans('admin.deleted'));
		}
	}
            

}