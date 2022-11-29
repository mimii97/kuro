<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;



class Reaction extends Model {

protected $table    = 'reactions';
protected $fillable = [
		'id',
		'admin_id',
        'like',
        'dislike',
        'user_id',
        'blog_id',
		'created_at',
		'updated_at',
	];

	/**
    * user_id relation method
    * @param void
    * @return object data
    */
   public function user(){
      return $this->belongsTo(\App\Models\User::class);
   }

	/**
    * blog_id relation method
    * @param void
    * @return object data
    */
   public function blog(){
      return $this->belongsTo(\App\Models\Blog::class);
   }

 	

   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($reaction) {
			//$reaction->user_id()->delete();
			//$reaction->user_id()->delete();
         });
   }
		
}
