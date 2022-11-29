<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\InfosDataTable;
use Carbon\Carbon;
use App\Models\Info;

use App\Http\Controllers\Validations\InfosRequest;


class Infos extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:infos_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:infos_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:infos_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:infos_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(InfosDataTable $infos)
            {
               return $infos->render('admin.infos.index',['title'=>trans('admin.infos')]);
            }


            

            public function create()
            {
            	
               return view('admin.infos.create',['title'=>trans('admin.create')]);
            }

            

            public function store(InfosRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['logo'] = "";
$data['admin_id'] = admin()->id(); 
		  		$infos = Info::create($data); 
               if(request()->hasFile('logo')){
              $infos->logo = it()->upload('logo','infos/'.$infos->id);
              $infos->save();
              }
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('infos'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$infos =  Info::find($id);
        		return is_null($infos) || empty($infos)?
        		backWithError(trans("admin.undefinedRecord"),aurl("infos")) :
        		view('admin.infos.show',[
				    'title'=>trans('admin.show'),
					'infos'=>$infos
        		]);
            }


            

            public function edit($id)
            {
        		$infos =  Info::find($id);
        		return is_null($infos) || empty($infos)?
        		backWithError(trans("admin.undefinedRecord"),aurl("infos")) :
        		view('admin.infos.edit',[
				  'title'=>trans('admin.edit'),
				  'infos'=>$infos
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new InfosRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(InfosRequest $request,$id)
            {
              // Check Record Exists
              $infos =  Info::find($id);
              if(is_null($infos) || empty($infos)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("infos"));
              }
              $data = $this->updateFillableColumns(); 
              $data['admin_id'] = admin()->id(); 
               if(request()->hasFile('logo')){
              it()->delete($infos->logo);
              $data['logo'] = it()->upload('logo','infos');
               } 
              Info::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('infos'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$infos = Info::find($id);
		if(is_null($infos) || empty($infos)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("infos"));
		}
               		if(!empty($infos->logo)){
			it()->delete($infos->logo);		}

		it()->delete('info',$id);
		$infos->delete();
		return redirectWithSuccess(aurl("infos"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$infos = Info::find($id);
				if(is_null($infos) || empty($infos)){
					return backWithError(trans('admin.undefinedRecord'),aurl("infos"));
				}
                    					if(!empty($infos->logo)){
				  it()->delete($infos->logo);
				}
				it()->delete('info',$id);
				$infos->delete();
			}
			return redirectWithSuccess(aurl("infos"),trans('admin.deleted'));
		}else {
			$infos = Info::find($data);
			if(is_null($infos) || empty($infos)){
				return backWithError(trans('admin.undefinedRecord'),aurl("infos"));
			}
                    
			if(!empty($infos->logo)){
			 it()->delete($infos->logo);
			}			it()->delete('info',$data);
			$infos->delete();
			return redirectWithSuccess(aurl("infos"),trans('admin.deleted'));
		}
	}
            

}