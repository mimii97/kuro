<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Banner;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\BannersRequest;


class BannersApi extends Controller{
	protected $selectColumns = [
		"id",
		"description",
		"image",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$Banner = Banner::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Banner]);
            }


            

    public function store(BannersRequest $request)
    {
    	$data = $request->except("_token");
    	
              $data["user_id"] = auth()->id(); 
                $data["image"] = "";
        $Banner = Banner::create($data); 
               if(request()->hasFile("image")){
              $Banner->image = it()->upload("image","banners/".$Banner->id);
              $Banner->save();
              }

		  $Banner = Banner::with($this->arrWith())->find($Banner->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Banner
        ]);
    }


            

            public function show($id)
            {
                $Banner = Banner::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Banner) || empty($Banner)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Banner
              ]);  ;
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
            	$Banner = Banner::find($id);
            	if(is_null($Banner) || empty($Banner)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              $data["user_id"] = auth()->id(); 
               if(request()->hasFile("image")){
              it()->delete($Banner->image);
              $data["image"] = it()->upload("image","banners/".$Banner->id);
               }
              Banner::where("id",$id)->update($data);

              $Banner = Banner::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Banner
               ]);
            }

            

            public function destroy($id)
            {
               $banners = Banner::find($id);
            	if(is_null($banners) || empty($banners)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($banners->image)){
               it()->delete($banners->image);
              }
               it()->delete("banner",$id);

               $banners->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $banners = Banner::find($id);
	            	if(is_null($banners) || empty($banners)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($banners->image)){
                    	it()->delete($banners->image);
                    	}
                    	it()->delete("banner",$id);
                    	$banners->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $banners = Banner::find($data);
	            	if(is_null($banners) || empty($banners)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($banners->image)){
                    	it()->delete($banners->image);
                    	}
                    	it()->delete("banner",$data);

                    $banners->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}