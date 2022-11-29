<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Comment;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\CommentsRequest;


class CommentsApi extends Controller{
	protected $selectColumns = [
		"id",
		"content",
		"user_id",
		"blog_id",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$Comment = Comment::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Comment]);
            }


            

    public function store(CommentsRequest $request)
    {
    	$data = $request->except("_token");
    	//data should have blog_id (if can user_id)
        
        $Comment = Comment::create($data); 

		  $Comment = Comment::with($this->arrWith())->find($Comment->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Comment
        ]);
    }


            

            public function show($id)
            {
                $Comment = Comment::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Comment) || empty($Comment)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Comment
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new CommentsRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(CommentsRequest $request,$id)
            {
            	$Comment = Comment::find($id);
            	if(is_null($Comment) || empty($Comment)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              Comment::where("id",$id)->update($data);

              $Comment = Comment::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Comment
               ]);
            }

            

            public function destroy($id)
            {
               $comments = Comment::find($id);
            	if(is_null($comments) || empty($comments)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("comment",$id);

               $comments->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $comments = Comment::find($id);
	            	if(is_null($comments) || empty($comments)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("comment",$id);
                    	$comments->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $comments = Comment::find($data);
	            	if(is_null($comments) || empty($comments)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("comment",$data);

                    $comments->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}