<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\DataTables\UserBFOTPlansDataTable;
use Carbon\Carbon;
use App\Models\BFOTPlan;

use App\Models\User;



class UserBFOTPlans extends Controller
{

	public function __construct() {

	}

	

            
            public function index(UserBFOTPlansDataTable $bfotplans)
            {
               return $bfotplans->render('user.bfotplans.index',['title'=>trans('user.bfotplans')]);
            }
         
           
            
            public function show($id)
            {
              $bfotplans =  BFOTPlan::find($id);
              return is_null($bfotplans) || empty($bfotplans)?
              backWithError(trans("admin.undefinedRecord"),url("bfotplans")) :
              view('user.bfotplans.show',[
              'title'=>trans('user.show'),
            'bfotplans'=>$bfotplans
              ]);
            }


         
            

}