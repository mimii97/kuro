<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\ICOsDataTable;
use Carbon\Carbon;
use App\Models\ICO;

use App\Http\Controllers\Validations\ICOsRequest;


class ICOs extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:icos_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:icos_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:icos_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:icos_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(ICOsDataTable $icos)
            {
               return $icos->render('admin.icos.index',['title'=>trans('admin.icos')]);
            }

            

            

            public function create()
            {
            	
               return view('admin.icos.create',['title'=>trans('admin.create')]);
            }

            

            public function store(ICOsRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['image'] = "";
              	$data['open_date'] = date('Y-m-d h:i', strtotime(request('open_date')));
				$data['admin_id'] = admin()->id(); 
		  		$icos = ICO::create($data); 
               if(request()->hasFile('image')){
              $icos->image = it()->upload('image','icos/'.$icos->id);
              $icos->save();
              }
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('icos'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$icos =  ICO::find($id);
        		return is_null($icos) || empty($icos)?
        		backWithError(trans("admin.undefinedRecord"),aurl("icos")) :
        		view('admin.icos.show',[
				    'title'=>trans('admin.show'),
					'icos'=>$icos
        		]);
            }


            

            public function edit($id)
            {
        		$icos =  ICO::find($id);
        		return is_null($icos) || empty($icos)?
        		backWithError(trans("admin.undefinedRecord"),aurl("icos")) :
        		view('admin.icos.edit',[
				  'title'=>trans('admin.edit'),
				  'icos'=>$icos
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new ICOsRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(ICOsRequest $request,$id)
            {
              // Check Record Exists
              $icos =  ICO::find($id);
              if(is_null($icos) || empty($icos)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("icos"));
              }
              $data = $this->updateFillableColumns(); 
              $data['admin_id'] = admin()->id(); 
               if(request()->hasFile('image')){
              it()->delete($icos->image);
              $data['image'] = it()->upload('image','icos');
               } 
              $data['open_date'] = date('Y-m-d H:i', strtotime(request('open_date')));
              ICO::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('icos'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$icos = ICO::find($id);
		if(is_null($icos) || empty($icos)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("icos"));
		}
               		if(!empty($icos->image)){
			it()->delete($icos->image);		}

		it()->delete('ico',$id);
		$icos->delete();
		return redirectWithSuccess(aurl("icos"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$icos = ICO::find($id);
				if(is_null($icos) || empty($icos)){
					return backWithError(trans('admin.undefinedRecord'),aurl("icos"));
				}
                    					if(!empty($icos->image)){
				  it()->delete($icos->image);
				}
				it()->delete('ico',$id);
				$icos->delete();
			}
			return redirectWithSuccess(aurl("icos"),trans('admin.deleted'));
		}else {
			$icos = ICO::find($data);
			if(is_null($icos) || empty($icos)){
				return backWithError(trans('admin.undefinedRecord'),aurl("icos"));
			}
                    
			if(!empty($icos->image)){
			 it()->delete($icos->image);
			}			it()->delete('ico',$data);
			$icos->delete();
			return redirectWithSuccess(aurl("icos"),trans('admin.deleted'));
		}
	}
            

}