<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\test;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\testRequest;


class testApi extends Controller{
	protected $selectColumns = [
		"id",
		"test",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$test = test::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$test]);
            }


            

    public function store(testRequest $request)
    {
    	$data = $request->except("_token");
    	
        $test = test::create($data); 

		  $test = test::with($this->arrWith())->find($test->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$test
        ]);
    }


            

            public function show($id)
            {
                $test = test::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($test) || empty($test)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $test
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new testRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(testRequest $request,$id)
            {
            	$test = test::find($id);
            	if(is_null($test) || empty($test)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              test::where("id",$id)->update($data);

              $test = test::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $test
               ]);
            }

            

            public function destroy($id)
            {
               $test = test::find($id);
            	if(is_null($test) || empty($test)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("test",$id);

               $test->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $test = test::find($id);
	            	if(is_null($test) || empty($test)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("test",$id);
                    	$test->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $test = test::find($data);
	            	if(is_null($test) || empty($test)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("test",$data);

                    $test->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}