<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Slide;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\SlidesRequest;


class SlidesApi extends Controller{
	protected $selectColumns = [
		"id",
		"image",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$Slide = Slide::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Slide]);
            }


            

    public function store(SlidesRequest $request)
    {
    	$data = $request->except("_token");
    	
              $data["user_id"] = auth()->id(); 
                $data["image"] = "";
        $Slide = Slide::create($data); 
               if(request()->hasFile("image")){
              $Slide->image = it()->upload("image","slides/".$Slide->id);
              $Slide->save();
              }

		  $Slide = Slide::with($this->arrWith())->find($Slide->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Slide
        ]);
    }


            

            public function show($id)
            {
                $Slide = Slide::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Slide) || empty($Slide)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Slide
              ]);  ;
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
            	$Slide = Slide::find($id);
            	if(is_null($Slide) || empty($Slide)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              $data["user_id"] = auth()->id(); 
               if(request()->hasFile("image")){
              it()->delete($Slide->image);
              $data["image"] = it()->upload("image","slides/".$Slide->id);
               }
              Slide::where("id",$id)->update($data);

              $Slide = Slide::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Slide
               ]);
            }

            

            public function destroy($id)
            {
               $slides = Slide::find($id);
            	if(is_null($slides) || empty($slides)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($slides->image)){
               it()->delete($slides->image);
              }
               it()->delete("slide",$id);

               $slides->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $slides = Slide::find($id);
	            	if(is_null($slides) || empty($slides)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($slides->image)){
                    	it()->delete($slides->image);
                    	}
                    	it()->delete("slide",$id);
                    	$slides->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $slides = Slide::find($data);
	            	if(is_null($slides) || empty($slides)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($slides->image)){
                    	it()->delete($slides->image);
                    	}
                    	it()->delete("slide",$data);

                    $slides->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}