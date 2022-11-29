<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\VotePlan;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\VotePlansRequest;


class VotePlansApi extends Controller{
	protected $selectColumns = [
		"id",
		"type",
		"description",
		"num_votes_cond",
		"kuro_balance_cond",
		"revenue",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$VotePlan = VotePlan::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$VotePlan]);
            }


            

    public function store(VotePlansRequest $request)
    {
    	$data = $request->except("_token");
    	
              $data["user_id"] = auth()->id(); 
        $VotePlan = VotePlan::create($data); 

		  $VotePlan = VotePlan::with($this->arrWith())->find($VotePlan->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$VotePlan
        ]);
    }


            

            public function show($id)
            {
                $VotePlan = VotePlan::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($VotePlan) || empty($VotePlan)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $VotePlan
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new VotePlansRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(VotePlansRequest $request,$id)
            {
            	$VotePlan = VotePlan::find($id);
            	if(is_null($VotePlan) || empty($VotePlan)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              $data["user_id"] = auth()->id(); 
              VotePlan::where("id",$id)->update($data);

              $VotePlan = VotePlan::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $VotePlan
               ]);
            }

            

            public function destroy($id)
            {
               $voteplans = VotePlan::find($id);
            	if(is_null($voteplans) || empty($voteplans)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("voteplan",$id);

               $voteplans->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $voteplans = VotePlan::find($id);
	            	if(is_null($voteplans) || empty($voteplans)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("voteplan",$id);
                    	$voteplans->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $voteplans = VotePlan::find($data);
	            	if(is_null($voteplans) || empty($voteplans)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("voteplan",$data);

                    $voteplans->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}