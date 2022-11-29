<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class IcoUser extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'ico_users';
protected $fillable = [
		'id',
		'admin_id',
        'amount',
        'status',

        'purchase_method',

        'user_id',
        'i_c_o_id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	/**
    * user_id relation method
    * @param void
    * @return object data
    */
   public function user_id(){
      return $this->belongsTo(\App\Models\User::class,'id','user_id');
   }

	/**
    * i_c_o_id relation method
    * @param void
    * @return object data
    */
   public function i_c_o_id(){
      return $this->belongsTo(\App\Models\ICO::class,'id','i_c_o_id');
   }

 	

   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($icouser) {
			//$icouser->user_id()->delete();
			//$icouser->user_id()->delete();
         });
   }
		
}
