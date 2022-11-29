<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;



class VotePlan extends Model {

protected $table    = 'vote_plans';
protected $fillable = [
		'id',
		'admin_id',
        'type',
        'description',
        'num_votes_cond',
        'kuro_balance_cond',
        'revenue',
		'created_at',
		'updated_at',
	];

	

   public function admin_id() {
	   return $this->hasOne(\App\Models\Admin::class, 'id', 'admin_id');
   }
	

	

   public function users(){
      return $this->hasMany(\App\Models\User::class);
   }

 	

   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($voteplan) {
			//$voteplan->users()->delete();
         });
   }
		
}
