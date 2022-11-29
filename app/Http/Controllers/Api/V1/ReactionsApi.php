<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Reaction;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\ReactionsRequest;


class ReactionsApi extends Controller{
	protected $selectColumns = [
		"id",
		"like",
		"dislike",
		"user_id",
		"blog_id",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$Reaction = Reaction::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Reaction]);
            }


            

    public function store(ReactionsRequest $request)
    {
    	$data = $request->except("_token");
    	
        $Reaction = Reaction::create($data); 

		  $Reaction = Reaction::with($this->arrWith())->find($Reaction->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Reaction
        ]);
    }


            

            public function show($id)
            {
                $Reaction = Reaction::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Reaction) || empty($Reaction)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Reaction
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new ReactionsRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(ReactionsRequest $request,$id)
            {
            	$Reaction = Reaction::find($id);
            	if(is_null($Reaction) || empty($Reaction)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              Reaction::where("id",$id)->update($data);

              $Reaction = Reaction::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Reaction
               ]);
            }

            

            public function destroy($id)
            {
               $reactions = Reaction::find($id);
            	if(is_null($reactions) || empty($reactions)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("reaction",$id);

               $reactions->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $reactions = Reaction::find($id);
	            	if(is_null($reactions) || empty($reactions)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("reaction",$id);
                    	$reactions->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $reactions = Reaction::find($data);
	            	if(is_null($reactions) || empty($reactions)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("reaction",$data);

                    $reactions->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}