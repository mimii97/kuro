<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\BFOTPlan;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\BFOTPlansRequest;


class BFOTPlansApi extends Controller{
	protected $selectColumns = [
		"id",
		"type",
		"description",
		"num_of_refs",
		"revenue",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$BFOTPlan = BFOTPlan::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$BFOTPlan]);
            }


            

    public function store(BFOTPlansRequest $request)
    {
    	$data = $request->except("_token");
    	
              $data["user_id"] = auth()->id(); 
        $BFOTPlan = BFOTPlan::create($data); 

		  $BFOTPlan = BFOTPlan::with($this->arrWith())->find($BFOTPlan->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$BFOTPlan
        ]);
    }


            

            public function show($id)
            {
                $BFOTPlan = BFOTPlan::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($BFOTPlan) || empty($BFOTPlan)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $BFOTPlan
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new BFOTPlansRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(BFOTPlansRequest $request,$id)
            {
            	$BFOTPlan = BFOTPlan::find($id);
            	if(is_null($BFOTPlan) || empty($BFOTPlan)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              $data["user_id"] = auth()->id(); 
              BFOTPlan::where("id",$id)->update($data);

              $BFOTPlan = BFOTPlan::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $BFOTPlan
               ]);
            }

            

            public function destroy($id)
            {
               $bfotplans = BFOTPlan::find($id);
            	if(is_null($bfotplans) || empty($bfotplans)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("bfotplan",$id);

               $bfotplans->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $bfotplans = BFOTPlan::find($id);
	            	if(is_null($bfotplans) || empty($bfotplans)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("bfotplan",$id);
                    	$bfotplans->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $bfotplans = BFOTPlan::find($data);
	            	if(is_null($bfotplans) || empty($bfotplans)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("bfotplan",$data);

                    $bfotplans->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}