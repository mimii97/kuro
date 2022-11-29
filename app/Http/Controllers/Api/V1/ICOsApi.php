<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ICO;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\ICOsRequest;


class ICOsApi extends Controller{
	protected $selectColumns = [
		"id",
		"image",
		"description",
		"open_date",
		"status",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$ICO = ICO::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
                return view('')->with(array('icos'=>$ICO));
                //return successResponseJson(["data"=>$ICO]);
            }


            

    public function store(ICOsRequest $request)
    {
    	$data = $request->except("_token");
    	
              $data["user_id"] = auth()->id(); 
                $data["image"] = "";
                $ICO = ICO::create($data); 
               if(request()->hasFile("image")){
              $ICO->image = it()->upload("image","icos/".$ICO->id);
              $ICO->save();
              }

		  $ICO = ICO::with($this->arrWith())->find($ICO->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$ICO
        ]);
    }


            

            public function show($id)
            {
                $ICO = ICO::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($ICO) || empty($ICO)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $ICO
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new ICOsRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(ICOsRequest $request,$id)
            {
            	$ICO = ICO::find($id);
            	if(is_null($ICO) || empty($ICO)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              $data["user_id"] = auth()->id(); 
               if(request()->hasFile("image")){
              it()->delete($ICO->image);
              $data["image"] = it()->upload("image","icos/".$ICO->id);
               }
              ICO::where("id",$id)->update($data);

              $ICO = ICO::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $ICO
               ]);
            }

            

            public function destroy($id)
            {
               $icos = ICO::find($id);
            	if(is_null($icos) || empty($icos)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($icos->image)){
               it()->delete($icos->image);
              }
               it()->delete("ico",$id);

               $icos->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $icos = ICO::find($id);
	            	if(is_null($icos) || empty($icos)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($icos->image)){
                    	it()->delete($icos->image);
                    	}
                    	it()->delete("ico",$id);
                    	$icos->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $icos = ICO::find($data);
	            	if(is_null($icos) || empty($icos)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($icos->image)){
                    	it()->delete($icos->image);
                    	}
                    	it()->delete("ico",$data);

                    $icos->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}