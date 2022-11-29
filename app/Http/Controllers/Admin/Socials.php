<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\SocialsDataTable;
use Carbon\Carbon;
use App\Models\Social;

use App\Http\Controllers\Validations\SocialsRequest;


class Socials extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:socials_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:socials_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:socials_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:socials_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(SocialsDataTable $socials)
            {
               return $socials->render('admin.socials.index',['title'=>trans('admin.socials')]);
            }


            

            public function create()
            {
            	
               return view('admin.socials.create',['title'=>trans('admin.create')]);
            }

            

            public function store(SocialsRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['logo'] = "";
$data['file'] = "";
$data['admin_id'] = admin()->id(); 
		  		$socials = Social::create($data); 
               if(request()->hasFile('logo')){
              $socials->logo = it()->upload('logo','socials/'.$socials->id);
              $socials->save();
              }
               if(request()->hasFile('file')){
              $socials->file = it()->upload('file','socials/'.$socials->id);
              $socials->save();
              }
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('socials'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$socials =  Social::find($id);
        		return is_null($socials) || empty($socials)?
        		backWithError(trans("admin.undefinedRecord"),aurl("socials")) :
        		view('admin.socials.show',[
				    'title'=>trans('admin.show'),
					'socials'=>$socials
        		]);
            }


            

            public function edit($id)
            {
        		$socials =  Social::find($id);
        		return is_null($socials) || empty($socials)?
        		backWithError(trans("admin.undefinedRecord"),aurl("socials")) :
        		view('admin.socials.edit',[
				  'title'=>trans('admin.edit'),
				  'socials'=>$socials
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new SocialsRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(SocialsRequest $request,$id)
            {
              // Check Record Exists
              $socials =  Social::find($id);
              if(is_null($socials) || empty($socials)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("socials"));
              }
              $data = $this->updateFillableColumns(); 
              $data['admin_id'] = admin()->id(); 
               if(request()->hasFile('logo')){
              it()->delete($socials->logo);
              $data['logo'] = it()->upload('logo','socials');
               } 
               if(request()->hasFile('file')){
              it()->delete($socials->file);
              $data['file'] = it()->upload('file','socials');
               } 
              Social::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('socials'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$socials = Social::find($id);
		if(is_null($socials) || empty($socials)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("socials"));
		}
               		if(!empty($socials->logo)){
			it()->delete($socials->logo);		}
		if(!empty($socials->file)){
			it()->delete($socials->file);		}

		it()->delete('social',$id);
		$socials->delete();
		return redirectWithSuccess(aurl("socials"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$socials = Social::find($id);
				if(is_null($socials) || empty($socials)){
					return backWithError(trans('admin.undefinedRecord'),aurl("socials"));
				}
                    					if(!empty($socials->logo)){
				  it()->delete($socials->logo);
				}				if(!empty($socials->file)){
				  it()->delete($socials->file);
				}
				it()->delete('social',$id);
				$socials->delete();
			}
			return redirectWithSuccess(aurl("socials"),trans('admin.deleted'));
		}else {
			$socials = Social::find($data);
			if(is_null($socials) || empty($socials)){
				return backWithError(trans('admin.undefinedRecord'),aurl("socials"));
			}
                    
			if(!empty($socials->logo)){
			 it()->delete($socials->logo);
			}			if(!empty($socials->file)){
			 it()->delete($socials->file);
			}			it()->delete('social',$data);
			$socials->delete();
			return redirectWithSuccess(aurl("socials"),trans('admin.deleted'));
		}
	}
            

}