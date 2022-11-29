<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\IcoUser;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\IcoUsersRequest;


class IcoUsersApi extends Controller{
	protected $selectColumns = [
		"id",
		"amount",
		"status",
		"purchase_method",
		"user_id",
		"i_c_o_id",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$IcoUser = IcoUser::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$IcoUser]);
            }


            

    public function store(IcoUsersRequest $request)
    {
    	$data = $request->except("_token");
    	
        $IcoUser = IcoUser::create($data); 

		  $IcoUser = IcoUser::with($this->arrWith())->find($IcoUser->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$IcoUser
        ]);
    }


            

            public function show($id)
            {
                $IcoUser = IcoUser::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($IcoUser) || empty($IcoUser)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $IcoUser
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new IcoUsersRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(IcoUsersRequest $request,$id)
            {
            	$IcoUser = IcoUser::find($id);
            	if(is_null($IcoUser) || empty($IcoUser)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              IcoUser::where("id",$id)->update($data);

              $IcoUser = IcoUser::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $IcoUser
               ]);
            }

            

            public function destroy($id)
            {
               $icousers = IcoUser::find($id);
            	if(is_null($icousers) || empty($icousers)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("icouser",$id);

               $icousers->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $icousers = IcoUser::find($id);
	            	if(is_null($icousers) || empty($icousers)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("icouser",$id);
                    	$icousers->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $icousers = IcoUser::find($data);
	            	if(is_null($icousers) || empty($icousers)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("icouser",$data);

                    $icousers->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}