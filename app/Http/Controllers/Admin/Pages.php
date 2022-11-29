<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\PagesDataTable;
use Carbon\Carbon;
use App\Models\Page;

use App\Http\Controllers\Validations\PagesRequest;


class Pages extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:pages_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:pages_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:pages_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:pages_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(PagesDataTable $pages)
            {
               return $pages->render('admin.pages.index',['title'=>trans('admin.pages')]);
            }


            

            public function create()
            {
            	
               return view('admin.pages.create',['title'=>trans('admin.create')]);
            }

            

            public function store(PagesRequest $request)
            {
                //dd($request);
                $data = $request->except("_token", "_method");
            		$pages = Page::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('pages'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$pages =  Page::find($id);
        		return is_null($pages) || empty($pages)?
        		backWithError(trans("admin.undefinedRecord"),aurl("pages")) :
        		view('admin.pages.show',[
				    'title'=>trans('admin.show'),
					'pages'=>$pages
        		]);
            }


            

            public function edit($id)
            {
        		$pages =  Page::find($id);
        		return is_null($pages) || empty($pages)?
        		backWithError(trans("admin.undefinedRecord"),aurl("pages")) :
        		view('admin.pages.edit',[
				  'title'=>trans('admin.edit'),
				  'pages'=>$pages
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new PagesRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(PagesRequest $request,$id)
            {
              // Check Record Exists
              $pages =  Page::find($id);
              if(is_null($pages) || empty($pages)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("pages"));
              }
              $data = $this->updateFillableColumns(); 
              Page::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('pages'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$pages = Page::find($id);
		if(is_null($pages) || empty($pages)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("pages"));
		}
               
		it()->delete('page',$id);
		$pages->delete();
		return redirectWithSuccess(aurl("pages"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$pages = Page::find($id);
				if(is_null($pages) || empty($pages)){
					return backWithError(trans('admin.undefinedRecord'),aurl("pages"));
				}
                    	
				it()->delete('page',$id);
				$pages->delete();
			}
			return redirectWithSuccess(aurl("pages"),trans('admin.deleted'));
		}else {
			$pages = Page::find($data);
			if(is_null($pages) || empty($pages)){
				return backWithError(trans('admin.undefinedRecord'),aurl("pages"));
			}
                    
			it()->delete('page',$data);
			$pages->delete();
			return redirectWithSuccess(aurl("pages"),trans('admin.deleted'));
		}
	}
            

}