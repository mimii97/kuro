<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class BFOTPlan extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'b_f_o_t_plans';
protected $fillable = [
		'id',
		'admin_id',
        'type',
        'description',
        'num_of_refs_cond',
        'kuro_balance_cond',
        'revenue',
		'created_at',
		'updated_at',
		'deleted_at',
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
         static::deleting(function($bfotplan) {
         });
   }
		
}
