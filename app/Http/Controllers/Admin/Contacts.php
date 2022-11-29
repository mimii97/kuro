<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\ContactsDataTable;
use Carbon\Carbon;
use App\Models\Contact;

use App\Http\Controllers\Validations\ContactsRequest;

class Contacts extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:contacts_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:contacts_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:contacts_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:contacts_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            public function index(ContactsDataTable $contacts)
            {
               return $contacts->render('admin.contacts.index',['title'=>trans('admin.contacts')]);
            }


            public function create()
            {
            	
               return view('admin.contacts.create',['title'=>trans('admin.create')]);
            }

            public function store(ContactsRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$contacts = Contact::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('contacts'.$redirect), trans('admin.added')); }

            public function show($id)
            {
        		$contacts =  Contact::find($id);
        		return is_null($contacts) || empty($contacts)?
        		backWithError(trans("admin.undefinedRecord"),aurl("contacts")) :
        		view('admin.contacts.show',[
				    'title'=>trans('admin.show'),
					'contacts'=>$contacts
        		]);
            }


            public function edit($id)
            {
                $contacts =  Contact::find($id);
                return is_null($contacts) || empty($contacts)?
                backWithError(trans("admin.undefinedRecord"),aurl("contacts")) :
                view('admin.contacts.edit',[
                'title'=>trans('admin.edit'),
                'contacts'=>$contacts
                ]);
            }


            public function updateFillableColumns() {
                $fillableCols = [];
                foreach (array_keys((new ContactsRequest)->attributes()) as $fillableUpdate) {
                  if (!is_null(request($fillableUpdate))) {
                    $fillableCols[$fillableUpdate] = request($fillableUpdate);
                  }
                }
                return $fillableCols;
			      }

            public function update(ContactsRequest $request,$id)
            {
              // Check Record Exists
              $contacts =  Contact::find($id);
              if(is_null($contacts) || empty($contacts)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("contacts"));
              }
              $data = $this->updateFillableColumns(); 
              Contact::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('contacts'.$redirect), trans('admin.updated'));
            }

          public function destroy($id){
              $contacts = Contact::find($id);
              if(is_null($contacts) || empty($contacts)){
                return backWithSuccess(trans('admin.undefinedRecord'),aurl("contacts"));
              }
                        
              it()->delete('contact',$id);
              $contacts->delete();
              return redirectWithSuccess(aurl("contacts"),trans('admin.deleted'));
          }


        public function multi_delete(){
          $data = request('selected_data');
          if(is_array($data)){
            foreach($data as $id){
              $contacts = Contact::find($id);
              if(is_null($contacts) || empty($contacts)){
                return backWithError(trans('admin.undefinedRecord'),aurl("contacts"));
              }
                            
              it()->delete('contact',$id);
              $contacts->delete();
            }
            return redirectWithSuccess(aurl("contacts"),trans('admin.deleted'));
          }else {
            $contacts = Contact::find($data);
            if(is_null($contacts) || empty($contacts)){
              return backWithError(trans('admin.undefinedRecord'),aurl("contacts"));
            }
                          
            it()->delete('contact',$data);
            $contacts->delete();
            return redirectWithSuccess(aurl("contacts"),trans('admin.deleted'));
          }
        }
            

}