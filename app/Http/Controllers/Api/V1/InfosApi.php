<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Info;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\InfosRequest;


class InfosApi extends Controller{
	protected $selectColumns = [
		"id",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$Info = Info::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Info]);
            }


            

    public function store(InfosRequest $request)
    {
    	$data = $request->except("_token");
    	
              $data["user_id"] = auth()->id(); 
        $Info = Info::create($data); 

		  $Info = Info::with($this->arrWith())->find($Info->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Info
        ]);
    }


            

            public function show($id)
            {
                $Info = Info::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Info) || empty($Info)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Info
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new InfosRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(InfosRequest $request,$id)
            {
            	$Info = Info::find($id);
            	if(is_null($Info) || empty($Info)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              $data["user_id"] = auth()->id(); 
              Info::where("id",$id)->update($data);

              $Info = Info::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Info
               ]);
            }

            

            public function destroy($id)
            {
               $infos = Info::find($id);
            	if(is_null($infos) || empty($infos)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($infos->logo)){
               it()->delete($infos->logo);
              }
               it()->delete("info",$id);

               $infos->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $infos = Info::find($id);
	            	if(is_null($infos) || empty($infos)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($infos->logo)){
                    	it()->delete($infos->logo);
                    	}
                    	it()->delete("info",$id);
                    	$infos->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $infos = Info::find($data);
	            	if(is_null($infos) || empty($infos)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($infos->logo)){
                    	it()->delete($infos->logo);
                    	}
                    	it()->delete("info",$data);

                    $infos->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}