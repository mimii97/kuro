<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\VotePlansDataTable;
use Carbon\Carbon;
use App\Models\VotePlan;

use App\Http\Controllers\Validations\VotePlansRequest;


class VotePlans extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:voteplans_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:voteplans_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:voteplans_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:voteplans_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(VotePlansDataTable $voteplans)
            {
               return $voteplans->render('admin.voteplans.index',['title'=>trans('admin.voteplans')]);
            }


            

            public function create()
            {
            	
               return view('admin.voteplans.create',['title'=>trans('admin.create')]);
            }

            

            public function store(VotePlansRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id(); 
		  		$voteplans = VotePlan::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('voteplans'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$voteplans =  VotePlan::find($id);
        		return is_null($voteplans) || empty($voteplans)?
        		backWithError(trans("admin.undefinedRecord"),aurl("voteplans")) :
        		view('admin.voteplans.show',[
				    'title'=>trans('admin.show'),
					'voteplans'=>$voteplans
        		]);
            }


            

            public function edit($id)
            {
        		$voteplans =  VotePlan::find($id);
        		return is_null($voteplans) || empty($voteplans)?
        		backWithError(trans("admin.undefinedRecord"),aurl("voteplans")) :
        		view('admin.voteplans.edit',[
				  'title'=>trans('admin.edit'),
				  'voteplans'=>$voteplans
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new VotePlansRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(VotePlansRequest $request,$id)
            {
              // Check Record Exists
              $voteplans =  VotePlan::find($id);
              if(is_null($voteplans) || empty($voteplans)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("voteplans"));
              }
              $data = $this->updateFillableColumns(); 
              $data['admin_id'] = admin()->id(); 
              VotePlan::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('voteplans'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$voteplans = VotePlan::find($id);
		if(is_null($voteplans) || empty($voteplans)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("voteplans"));
		}
               
		it()->delete('voteplan',$id);
		$voteplans->delete();
		return redirectWithSuccess(aurl("voteplans"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$voteplans = VotePlan::find($id);
				if(is_null($voteplans) || empty($voteplans)){
					return backWithError(trans('admin.undefinedRecord'),aurl("voteplans"));
				}
                    	
				it()->delete('voteplan',$id);
				$voteplans->delete();
			}
			return redirectWithSuccess(aurl("voteplans"),trans('admin.deleted'));
		}else {
			$voteplans = VotePlan::find($data);
			if(is_null($voteplans) || empty($voteplans)){
				return backWithError(trans('admin.undefinedRecord'),aurl("voteplans"));
			}
                    
			it()->delete('voteplan',$data);
			$voteplans->delete();
			return redirectWithSuccess(aurl("voteplans"),trans('admin.deleted'));
		}
	}
            

}