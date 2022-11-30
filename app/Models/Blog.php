<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Blog extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'blogs';
protected $fillable = [
		'id',
		'admin_id',
        'title',
        'body',
        'image',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	

   public function admin_id() {
	   return $this->hasOne(\App\Models\Admin::class, 'id', 'admin_id');
   }
	

	/**
    * likes relation method
    * @param void
    * @return object data
    */
    //get number of likes on a blog
   public function likes(){
      return $this->hasMany(\App\Models\Reaction::class)->where('like', '!=', 0);
   }

	/**
    * dislikes relation method
    * @param void
    * @return object data
    */
    //get number of dislikes on a blog
   public function dislikes(){
      return $this->hasMany(\App\Models\Reaction::class)->where('dislike', '!=', 0);
   }

	/**
    * comments relation method
    * @param void
    * @return object data
    */
    //get number of comments on a blog
   public function comments(){
      return $this->hasMany(\App\Models\Comment::class);
   }

 	

   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($blog) {
			//$blog->likes()->delete();
			//$blog->likes()->delete();
			//$blog->likes()->delete();
         });
   }
		
}
