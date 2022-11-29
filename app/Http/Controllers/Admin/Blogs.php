<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\BlogsDataTable;
use Carbon\Carbon;
use App\Models\Blog;

use App\Http\Controllers\Validations\BlogsRequest;


class Blogs extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:blogs_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:blogs_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:blogs_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:blogs_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	protected $selectColumns = [
		"id",
		"title",
		"body",
		"image",
	];
  public function arrWith(){
    return [];
 }

            

            public function index(BlogsDataTable $blogs)
            {
              
              return $blogs->render('admin.blogs.index',['title'=>trans('admin.blogs')]);
            }


            

            public function create()
            {
            	
               return view('admin.blogs.create',['title'=>trans('admin.create')]);
            }

            

            public function store(BlogsRequest $request)
            {
                $data = $request->except("_token", "_method");
            	  $data['image'] = "";
                $data['admin_id'] = admin()->id(); 
		  		      $blogs = Blog::create($data); 
                if(request()->hasFile('image')){
                  $blogs->image = it()->upload('image','blogs/'.$blogs->id);
                  $blogs->save();
                }
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('blogs'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$blogs =  Blog::find($id);
        		return is_null($blogs) || empty($blogs)?
        		backWithError(trans("admin.undefinedRecord"),aurl("blogs")) :
        		view('admin.blogs.show',[
              'title'=>trans('admin.show'),
              'blogs'=>$blogs
        		]);
            }


            

            public function edit($id)
            {
        		$blogs =  Blog::find($id);
        		return is_null($blogs) || empty($blogs)?
        		backWithError(trans("admin.undefinedRecord"),aurl("blogs")) :
        		view('admin.blogs.edit',[
              'title'=>trans('admin.edit'),
              'blogs'=>$blogs
        		]);
            }


            

            public function updateFillableColumns() {
              $fillableCols = [];
              foreach (array_keys((new BlogsRequest)->attributes()) as $fillableUpdate) {
                if (!is_null(request($fillableUpdate))) {
                  $fillableCols[$fillableUpdate] = request($fillableUpdate);
                }
              }
              return $fillableCols;
			    }

            public function update(BlogsRequest $request,$id)
            {
              // Check Record Exists
              $blogs =  Blog::find($id);
              if(is_null($blogs) || empty($blogs)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("blogs"));
              }
              $data = $this->updateFillableColumns(); 
              $data['admin_id'] = admin()->id(); 
               if(request()->hasFile('image')){
              it()->delete($blogs->image);
              $data['image'] = it()->upload('image','blogs');
               } 
              Blog::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('blogs'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$blogs = Blog::find($id);
		if(is_null($blogs) || empty($blogs)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("blogs"));
		}
               		if(!empty($blogs->image)){
			it()->delete($blogs->image);		}

		it()->delete('blog',$id);
		$blogs->delete();
		return redirectWithSuccess(aurl("blogs"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$blogs = Blog::find($id);
				if(is_null($blogs) || empty($blogs)){
					return backWithError(trans('admin.undefinedRecord'),aurl("blogs"));
				}
                    					if(!empty($blogs->image)){
				  it()->delete($blogs->image);
				}
				it()->delete('blog',$id);
				$blogs->delete();
			}
			return redirectWithSuccess(aurl("blogs"),trans('admin.deleted'));
		}else {
			$blogs = Blog::find($data);
			if(is_null($blogs) || empty($blogs)){
				return backWithError(trans('admin.undefinedRecord'),aurl("blogs"));
			}
                    
			if(!empty($blogs->image)){
			 it()->delete($blogs->image);
			}			it()->delete('blog',$data);
			$blogs->delete();
			return redirectWithSuccess(aurl("blogs"),trans('admin.deleted'));
		}
	}
            

}