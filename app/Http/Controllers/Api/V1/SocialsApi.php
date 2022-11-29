<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Social;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\SocialsRequest;


class SocialsApi extends Controller{
	protected $selectColumns = [
		"id",
		"name",
		"logo",
		"link",
		"file",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$Social = Social::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Social]);
            }


            

    public function store(SocialsRequest $request)
    {
    	$data = $request->except("_token");
    	
              $data["user_id"] = auth()->id(); 
                $data["logo"] = "";
                $data["file"] = "";
        $Social = Social::create($data); 
               if(request()->hasFile("logo")){
              $Social->logo = it()->upload("logo","socials/".$Social->id);
              $Social->save();
              }
               if(request()->hasFile("file")){
              $Social->file = it()->upload("file","socials/".$Social->id);
              $Social->save();
              }

		  $Social = Social::with($this->arrWith())->find($Social->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Social
        ]);
    }


            

            public function show($id)
            {
                $Social = Social::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Social) || empty($Social)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Social
              ]);  ;
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
            	$Social = Social::find($id);
            	if(is_null($Social) || empty($Social)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              $data["user_id"] = auth()->id(); 
               if(request()->hasFile("logo")){
              it()->delete($Social->logo);
              $data["logo"] = it()->upload("logo","socials/".$Social->id);
               }
               if(request()->hasFile("file")){
              it()->delete($Social->file);
              $data["file"] = it()->upload("file","socials/".$Social->id);
               }
              Social::where("id",$id)->update($data);

              $Social = Social::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Social
               ]);
            }

            

            public function destroy($id)
            {
               $socials = Social::find($id);
            	if(is_null($socials) || empty($socials)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($socials->logo)){
               it()->delete($socials->logo);
              }
              if(!empty($socials->file)){
               it()->delete($socials->file);
              }
               it()->delete("social",$id);

               $socials->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $socials = Social::find($id);
	            	if(is_null($socials) || empty($socials)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($socials->logo)){
                    	it()->delete($socials->logo);
                    	}
                    	if(!empty($socials->file)){
                    	it()->delete($socials->file);
                    	}
                    	it()->delete("social",$id);
                    	$socials->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $socials = Social::find($data);
	            	if(is_null($socials) || empty($socials)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($socials->logo)){
                    	it()->delete($socials->logo);
                    	}
                    	if(!empty($socials->file)){
                    	it()->delete($socials->file);
                    	}
                    	it()->delete("social",$data);

                    $socials->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}