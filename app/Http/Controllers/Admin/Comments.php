<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\CommentsDataTable;
use Carbon\Carbon;
use App\Models\Comment;

use App\Http\Controllers\Validations\CommentsRequest;


class Comments extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:comments_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:comments_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:comments_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:comments_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            

            public function index(CommentsDataTable $comments)
            {
              
              //$comments = Comment::query()->select("comments.*");
              /*$comments = Comment::all();
              foreach ($comments as $comment) {
                
                $comment->user_name = $comment->user->name;
                dd($comment->user_name);
              }*/

              return $comments->render('admin.comments.index',['title'=>trans('admin.comments')]);
            }


            

            public function create()
            {
            	
               return view('admin.comments.create',['title'=>trans('admin.create')]);
            }

            

            public function store(CommentsRequest $request)
            {
                dd($request);
                $data = $request->except("_token", "_method");
            		$comments = Comment::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('comments'.$redirect), trans('admin.added')); }

            

            public function show($id)
            {
        		$comments =  Comment::find($id);
        		return is_null($comments) || empty($comments)?
        		backWithError(trans("admin.undefinedRecord"),aurl("comments")) :
        		view('admin.comments.show',[
				    'title'=>trans('admin.show'),
					'comments'=>$comments
        		]);
            }


            

            public function edit($id)
            {
        		$comments =  Comment::find($id);
        		return is_null($comments) || empty($comments)?
        		backWithError(trans("admin.undefinedRecord"),aurl("comments")) :
        		view('admin.comments.edit',[
				  'title'=>trans('admin.edit'),
				  'comments'=>$comments
        		]);
            }


            

            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new CommentsRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(CommentsRequest $request,$id)
            {
              // Check Record Exists
              $comments =  Comment::find($id);
              if(is_null($comments) || empty($comments)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("comments"));
              }
              $data = $this->updateFillableColumns(); 
              Comment::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('comments'.$redirect), trans('admin.updated'));
            }

            

	public function destroy($id){
		$comments = Comment::find($id);
		if(is_null($comments) || empty($comments)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("comments"));
		}
               
		it()->delete('comment',$id);
		$comments->delete();
		return redirectWithSuccess(aurl("comments"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$comments = Comment::find($id);
				if(is_null($comments) || empty($comments)){
					return backWithError(trans('admin.undefinedRecord'),aurl("comments"));
				}
                    	
				it()->delete('comment',$id);
				$comments->delete();
			}
			return redirectWithSuccess(aurl("comments"),trans('admin.deleted'));
		}else {
			$comments = Comment::find($data);
			if(is_null($comments) || empty($comments)){
				return backWithError(trans('admin.undefinedRecord'),aurl("comments"));
			}
                    
			it()->delete('comment',$data);
			$comments->delete();
			return redirectWithSuccess(aurl("comments"),trans('admin.deleted'));
		}
	}
            

}