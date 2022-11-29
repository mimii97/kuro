<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\DataTables\UserIcoUsersDataTable;
use Carbon\Carbon;
use App\Models\ICO;

use App\Http\Controllers\Validations\ICOsRequest;


class UserICOsUsers extends Controller
{

	public function __construct() {
    $this->middleware('UserRole:icousers_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('UserRole:icousers_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('UserRole:icousers_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('UserRole:icousers_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

            public function index(UserIcoUsersDataTable $icos)
            {
              return $icos->render('user.icousers.index',['title'=>trans('user.icos')]);
              /*$icos = ICO::all();
                dd($icos);
                return view('')->with(array('icos'=>$icos));*/
            }

            public function show($id)
            {
                $icos =  ICO::find($id);
                dd($icos);
                return is_null($icos) || empty($icos)?
                backWithError(trans("user.undefinedRecord"),aurl("icos")) :
                view('user.icos.show',[
                'title'=>trans('user.show'),
                'icos'=>$icos
                ]);
            }
}