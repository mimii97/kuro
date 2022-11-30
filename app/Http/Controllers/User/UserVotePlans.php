<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\DataTables\UserVotePlansDataTable;
use Carbon\Carbon;
use App\Models\VotePlan;

use App\Http\Controllers\Validations\VotePlansRequest;
use App\Models\BFOTPlan;
use App\Models\User;



class UserVotePlans extends Controller
{
/*
->addColumn('num_comments', function ($vote_plan_for_this_user) {
			return $vote_plan_for_this_user->users()->find(auth()->user()->id)->comments()->count();	
		})
		->addColumn('num_likes', function ($vote_plan_for_this_user) {
			return $vote_plan_for_this_user->users()->find(auth()->user()->id)->likes();	
		})
		->addColumn('num_dislikes', function ($vote_plan_for_this_user) {
			return $vote_plan_for_this_user->users()->find(auth()->user()->id)->dislikes();	
		})
		->addColumn('vote_revenue', function ($vote_plan_for_this_user) {
			return $vote_plan_for_this_user->users()->find(auth()->user()->id)->vote_revenue($vote_plan_for_this_user);	
		})
		->addColumn('kuro_balance', function ($vote_plan_for_this_user) {
			return $vote_plan_for_this_user->users()->find(auth()->user()->id)->kuro_balance;	
		})




			

*/
	public function __construct() {

	
    
	}

	

           
            public function index(UserVotePlansDataTable $voteplans)
            {

               return $voteplans->render('user.voteplans.index',['title'=>trans('user.voteplans')]);
            }
         
         
            
            public function show($id)
            {
              $voteplans =  VotePlan::find($id);
              return is_null($voteplans) || empty($voteplans)?
              backWithError(trans("admin.undefinedRecord"),url("voteplans")) :
              view('user.voteplans.show',[
              'title'=>trans('user.show'),
            'voteplans'=>$voteplans
              ]);
            }


         
            

}