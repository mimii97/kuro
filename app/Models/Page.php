<?php
namespace App\Models;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Page extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'pages';
protected $fillable = [
		'id',
		'admin_id',
      'page_name',
		'created_at',
		'updated_at',
		'deleted_at',
	];

   public function slide(){
      return $this->belongsTo(Slide::class);
   }

 	

   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($page) {
         });
   }
		
}
