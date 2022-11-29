<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\BannersDataTable;
use Carbon\Carbon;
use App\Models\Banner;

use App\Http\Controllers\Validations\BannersRequest;


class Banners extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:banners_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:banners_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:banners_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:banners_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(BannersDataTable $banners)
            {
               return $banners->render('admin.banners.index',['title'=>trans('admin.banners')]);
            }


            

            public function create()
            {
            	
               return view('admin.banners.create',['title'=>trans('admin.create')]);
            }

            

            public function store(BannersRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['image'] = "";
$data['admin_id'] = admin()->id(); 
		  		$banners = Banner::create($data); 
               if(request()->hasFile('image')){
              $banners->image = it()->upload('image','banners/'.$banners->id);
              $banners->save();
              }
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('banners'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$banners =  Banner::find($id);
        		return is_null($banners) || empty($banners)?
        		backWithError(trans("admin.undefinedRecord"),aurl("banners")) :
        		view('admin.banners.show',[
				    'title'=>trans('admin.show'),
					'banners'=>$banners
        		]);
            }


            

            public function edit($id)
            {
        		$banners =  Banner::find($id);
        		return is_null($banners) || empty($banners)?
        		backWithError(trans("admin.undefinedRecord"),aurl("banners")) :
        		view('admin.banners.edit',[
				  'title'=>trans('admin.edit'),
				  'banners'=>$banners
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new BannersRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(BannersRequest $request,$id)
            {
              // Check Record Exists
              $banners =  Banner::find($id);
              if(is_null($banners) || empty($banners)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("banners"));
              }
              $data = $this->updateFillableColumns(); 
              $data['admin_id'] = admin()->id(); 
               if(request()->hasFile('image')){
              it()->delete($banners->image);
              $data['image'] = it()->upload('image','banners');
               } 
              Banner::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('banners'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$banners = Banner::find($id);
		if(is_null($banners) || empty($banners)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("banners"));
		}
               		if(!empty($banners->image)){
			it()->delete($banners->image);		}

		it()->delete('banner',$id);
		$banners->delete();
		return redirectWithSuccess(aurl("banners"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$banners = Banner::find($id);
				if(is_null($banners) || empty($banners)){
					return backWithError(trans('admin.undefinedRecord'),aurl("banners"));
				}
                    					if(!empty($banners->image)){
				  it()->delete($banners->image);
				}
				it()->delete('banner',$id);
				$banners->delete();
			}
			return redirectWithSuccess(aurl("banners"),trans('admin.deleted'));
		}else {
			$banners = Banner::find($data);
			if(is_null($banners) || empty($banners)){
				return backWithError(trans('admin.undefinedRecord'),aurl("banners"));
			}
                    
			if(!empty($banners->image)){
			 it()->delete($banners->image);
			}			it()->delete('banner',$data);
			$banners->delete();
			return redirectWithSuccess(aurl("banners"),trans('admin.deleted'));
		}
	}
            

}