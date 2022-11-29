<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Slide extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'slides';
protected $fillable = [
		'id',
		'admin_id',
        'image',
        'page_id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	

   public function admin_id() {
	   return $this->hasOne(\App\Models\Admin::class, 'id', 'admin_id');
   }
	

	/**
    * page_id relation method
    * @param void
    * @return object data
    */
   public function page(){
      return $this->hasOne(\App\Models\Page::class, 'page_id');
   }

 	

   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($slide) {
			//$slide->page_id()->delete();
         });
   }
		
}
