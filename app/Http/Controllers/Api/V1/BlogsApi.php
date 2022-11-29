<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Blog;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\BlogsRequest;


class BlogsApi extends Controller{
	protected $selectColumns = [
		"id",
		"title",
		"body",
		"image",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
                dd('1');
                $Blog = Blog::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
                return successResponseJson(["data"=>$Blog]);
            }

            //Get Comments of a blog
            public function blog_comments(Blog $blog)
            {
                $blog_comments = $blog->comments()->latest()->get();
                dd($blog_comments);
                return successResponseJson(["data"=>$blog_comments]);
                /*return view('comments.index', [
                    'comments' => $blog_comments
                ]);*/
            }


            

    public function store(BlogsRequest $request)
    {
    	$data = $request->except("_token");
    	
              $data["user_id"] = auth()->id(); 
                $data["image"] = "";
        $Blog = Blog::create($data); 
               if(request()->hasFile("image")){
              $Blog->image = it()->upload("image","blogs/".$Blog->id);
              $Blog->save();
              }

		  $Blog = Blog::with($this->arrWith())->find($Blog->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Blog
        ]);
    }


            

            public function show($id)
            {
                $Blog = Blog::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Blog) || empty($Blog)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Blog
              ]);  ;
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
            	$Blog = Blog::find($id);
            	if(is_null($Blog) || empty($Blog)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              $data["user_id"] = auth()->id(); 
               if(request()->hasFile("image")){
              it()->delete($Blog->image);
              $data["image"] = it()->upload("image","blogs/".$Blog->id);
               }
              Blog::where("id",$id)->update($data);

              $Blog = Blog::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Blog
               ]);
            }

            

            public function destroy($id)
            {
               $blogs = Blog::find($id);
            	if(is_null($blogs) || empty($blogs)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($blogs->image)){
               it()->delete($blogs->image);
              }
               it()->delete("blog",$id);

               $blogs->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $blogs = Blog::find($id);
	            	if(is_null($blogs) || empty($blogs)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($blogs->image)){
                    	it()->delete($blogs->image);
                    	}
                    	it()->delete("blog",$id);
                    	$blogs->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $blogs = Blog::find($data);
	            	if(is_null($blogs) || empty($blogs)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($blogs->image)){
                    	it()->delete($blogs->image);
                    	}
                    	it()->delete("blog",$data);

                    $blogs->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}