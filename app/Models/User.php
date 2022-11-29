<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable  implements JWTSubject {

	use SoftDeletes;
   use HasFactory, Notifiable;
   protected $primaryKey = 'id';
	protected $dates = ['deleted_at'];

protected $table    = 'users';
protected $fillable = [
		'id',
		'admin_id',
        'name',
        'email',
        'user_name',
        'age',
		'kuro_balance',
		'vote_plan_id',
		'b_f_o_t_plan_id',
		'referrer_id',
        'group_id',
        'password',
        'email_verified_at',
		'created_at',
		'updated_at',
		'deleted_at',
	];
   /**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
	
	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['referral_link'];

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier() {
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims() {
		return [];
	}

   public function vote(){
      return $this->belongsTo(\App\Models\VotePlan::class);
   }

   public function bfot(){
	return $this->belongsTo(\App\Models\BFOTPlan::class);
 }

	/**
	 * A user has a referrer.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function referrer()
	{
		return $this->belongsTo(User::class, 'referrer_id', 'id');
	}
	/**
	 * A user has many referrals.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function referrals()
	{
		return $this->hasMany(User::class, 'referrer_id', 'id');
	}

	/**
	 * Get the user's referral link.
	 *
	 * @return string
	 */
	public function getReferralLinkAttribute()
	{
		return $this->referral_link = route('register', ['ref' => $this->username]);
	}

	/**
    * likes relation method
    * @param void
    * @return object data
    */
   	public function likes(){
      	return $this->hasMany(\App\Models\Reaction::class)->where('like', '!=', 0)->count('like');
   	}

	/**
    * dislikes relation method
    * @param void
    * @return object data
    */
   public function dislikes(){
      	return $this->hasMany(\App\Models\Reaction::class)->where('dislike', '!=', 0)->count('dislike');
   }

	/**
    * comments relation method
    * @param void
    * @return object data
    */
   	public function comments(){
      	return $this->hasMany(\App\Models\Comment::class)->count('id');
   	}


   	public function group_id(){
		return $this->hasOne(\App\Models\AdminGroup::class, 'id', 'group_id');
	}


	public function icos(){
		return $this->hasMany(\App\Models\ICO::class);
	}


	public function vote_revenue(VotePlan $vote_plan){
		//dd(1);
		$votes =  $this->likes() + $this->dislikes() + $this->comments();
		if ($votes >= $vote_plan->num_votes_cond)
			return 100;
		else
			return -100;
	}

	public function bfot_revenue(BFOTPlan $bfot_plan){
		return 100;
		$refs =  $this->referrals()->count();
		if ($refs >= $bfot_plan->num_refs_cond)
			return 100;
		else
			return -100;
	}



   public function role($name) {
		$exists_group_id = $this->getConnection()
			->getSchemaBuilder()
			->hasColumn($this->getTable(), 'group_id');
		if ($exists_group_id) {
         //dd($this->group_id);
         //if ($this->group_id == 2)
         //   return true;
			$explode_name = explode('_', $name);
			//dd($this->group_id());
			if (!empty($this->group_id()->first())) {
				$role = $this->group_id()->first()->role()->where('name', $explode_name[0])->first();
				if (!empty($role) && $role->{$explode_name[1]} == 'yes') {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

 	

   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($user) {
			//$user->likes()->delete();
			//$user->likes()->delete();
			//$user->likes()->delete();
         });
   }


	
		
}
