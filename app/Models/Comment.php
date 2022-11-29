<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use User;


class Comment extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'comments';
protected $fillable = [
		'id',
		'admin_id',
        'content',
        'user_id',
        'blog_id',
		'created_at',
		'updated_at',
		'deleted_at',
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
         static::deleting(function($comment) {
			//$comment->user_id()->delete();
			//$comment->user_id()->delete();
         });
   }
		
}
