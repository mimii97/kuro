<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\UsersRequest;


class UsersApi extends Controller{
	protected $selectColumns = [
		"id",
		"name",
		"email",
		"user_name",
		"age",
		"group_id",
		"vote_id",
		"vote_revenue",
		"kuro_balance_wallet",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$User = User::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$User]);
            }


            

    public function store(UsersRequest $request)
    {
    	$data = $request->except("_token");
    	
        $User = User::create($data); 

		  $User = User::with($this->arrWith())->find($User->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$User
        ]);
    }


            

            public function show($id)
            {
                $User = User::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($User) || empty($User)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $User
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new UsersRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(UsersRequest $request,$id)
            {
            	$User = User::find($id);
            	if(is_null($User) || empty($User)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              User::where("id",$id)->update($data);

              $User = User::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $User
               ]);
            }

            

            public function destroy($id)
            {
               $users = User::find($id);
            	if(is_null($users) || empty($users)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("user",$id);

               $users->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $users = User::find($id);
	            	if(is_null($users) || empty($users)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("user",$id);
                    	$users->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $users = User::find($data);
	            	if(is_null($users) || empty($users)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("user",$data);

                    $users->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}