<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Banner extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'banners';
protected $fillable = [
		'id',
		'admin_id',
        'description',
        'image',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	

   public function admin_id() {
	   return $this->hasOne(\App\Models\Admin::class, 'id', 'admin_id');
   }
	

 	

   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($banner) {
         });
   }
		
}
