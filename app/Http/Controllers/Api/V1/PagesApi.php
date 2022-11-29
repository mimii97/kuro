<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Page;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\PagesRequest;


class PagesApi extends Controller{
	protected $selectColumns = [
		"id",
		"page_name",
	];

            

            public function arrWith(){
               return [];
            }


            

            public function index()
            {
            	$Page = Page::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Page]);
            }


            

    public function store(PagesRequest $request)
    {
    	$data = $request->except("_token");
    	
        $Page = Page::create($data); 

		  $Page = Page::with($this->arrWith())->find($Page->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Page
        ]);
    }


            

            public function show($id)
            {
                $Page = Page::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Page) || empty($Page)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Page
              ]);  ;
            }


            

            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new PagesRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(PagesRequest $request,$id)
            {
            	$Page = Page::find($id);
            	if(is_null($Page) || empty($Page)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              Page::where("id",$id)->update($data);

              $Page = Page::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Page
               ]);
            }

            

            public function destroy($id)
            {
               $pages = Page::find($id);
            	if(is_null($pages) || empty($pages)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("page",$id);

               $pages->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $pages = Page::find($id);
	            	if(is_null($pages) || empty($pages)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("page",$id);
                    	$pages->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $pages = Page::find($data);
	            	if(is_null($pages) || empty($pages)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("page",$data);

                    $pages->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}