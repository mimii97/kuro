<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\JoinedUser;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\JoinedUsersRequest;


class JoinedUsersApi extends Controller{
	protected $selectColumns = [
		"id",
		"name",
		"email",
		"user_name",
		"age",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$JoinedUser = JoinedUser::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$JoinedUser]);
            }


            

    public function store(JoinedUsersRequest $request)
    {
    	$data = $request->except("_token");
    	
        $JoinedUser = JoinedUser::create($data); 

		  $JoinedUser = JoinedUser::with($this->arrWith())->find($JoinedUser->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$JoinedUser
        ]);
    }


            

            public function show($id)
            {
                $JoinedUser = JoinedUser::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($JoinedUser) || empty($JoinedUser)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $JoinedUser
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new JoinedUsersRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(JoinedUsersRequest $request,$id)
            {
            	$JoinedUser = JoinedUser::find($id);
            	if(is_null($JoinedUser) || empty($JoinedUser)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              JoinedUser::where("id",$id)->update($data);

              $JoinedUser = JoinedUser::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $JoinedUser
               ]);
            }

            

            public function destroy($id)
            {
               $joinedusers = JoinedUser::find($id);
            	if(is_null($joinedusers) || empty($joinedusers)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("joineduser",$id);

               $joinedusers->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $joinedusers = JoinedUser::find($id);
	            	if(is_null($joinedusers) || empty($joinedusers)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("joineduser",$id);
                    	$joinedusers->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $joinedusers = JoinedUser::find($data);
	            	if(is_null($joinedusers) || empty($joinedusers)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("joineduser",$data);

                    $joinedusers->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}