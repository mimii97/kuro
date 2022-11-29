<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\SlidesDataTable;
use Carbon\Carbon;
use App\Models\Slide;
use App\Models\Page;

use App\Http\Controllers\Validations\SlidesRequest;

class Slides extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:slides_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:slides_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:slides_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:slides_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            public function index(SlidesDataTable $slides)
            {
              return $slides->render('admin.slides.index',['title'=>trans('admin.slides')]);
            }


      
            public function create()
            {
            	
               return view('admin.slides.create',['title'=>trans('admin.create')]);
            }

            public function store(SlidesRequest $request)
            {
                $data = $request->except("_token", "_method");
            	  $data['image'] = "";
                $data['admin_id'] = admin()->id(); 
		  		      $slides = Slide::create($data); 
                if(request()->hasFile('image')){
                  $slides->image = it()->upload('image','slides/'.$slides->id);
                  $slides->save();
                }
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('slides'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$slides =  Slide::find($id);
        		return is_null($slides) || empty($slides)?
        		backWithError(trans("admin.undefinedRecord"),aurl("slides")) :
        		view('admin.slides.show',[
				    'title'=>trans('admin.show'),
					'slides'=>$slides
        		]);
            }


            

            public function edit($id)
            {
        		$slides =  Slide::find($id);
        		return is_null($slides) || empty($slides)?
        		backWithError(trans("admin.undefinedRecord"),aurl("slides")) :
        		view('admin.slides.edit',[
				  'title'=>trans('admin.edit'),
				  'slides'=>$slides
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new SlidesRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(SlidesRequest $request,$id)
            {
              // Check Record Exists
              $slides =  Slide::find($id);
              if(is_null($slides) || empty($slides)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("slides"));
              }
              $data = $this->updateFillableColumns(); 
              $data['admin_id'] = admin()->id(); 
               if(request()->hasFile('image')){
                  it()->delete($slides->image);
                  $data['image'] = it()->upload('image','slides');
               } 
              Slide::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('slides'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$slides = Slide::find($id);
		if(is_null($slides) || empty($slides)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("slides"));
		}
               		if(!empty($slides->image)){
			it()->delete($slides->image);		}

		it()->delete('slide',$id);
		$slides->delete();
		return redirectWithSuccess(aurl("slides"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$slides = Slide::find($id);
				if(is_null($slides) || empty($slides)){
					return backWithError(trans('admin.undefinedRecord'),aurl("slides"));
				}
                    					if(!empty($slides->image)){
				  it()->delete($slides->image);
				}
				it()->delete('slide',$id);
				$slides->delete();
			}
			return redirectWithSuccess(aurl("slides"),trans('admin.deleted'));
		}else {
			$slides = Slide::find($data);
			if(is_null($slides) || empty($slides)){
				return backWithError(trans('admin.undefinedRecord'),aurl("slides"));
			}
                    
			if(!empty($slides->image)){
			 it()->delete($slides->image);
			}			it()->delete('slide',$data);
			$slides->delete();
			return redirectWithSuccess(aurl("slides"),trans('admin.deleted'));
		}
	}
            

}