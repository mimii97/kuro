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
		'vote_revenue',
		'num_vote_plan_paid_prizes',
		'num_bfot_plan_paid_prizes',
		'num_paid_votes',
		'paid_vote_plan_balance',
		'num_paid_refs',
		'paid_bfot_plan_balance',
		'bfot_revenue',
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
      	return $this->hasMany(\App\Models\Reaction::class)->where('like', '!=', 0);
   	}

	/**
    * dislikes relation method
    * @param void
    * @return object data
    */
   public function dislikes(){
      	return $this->hasMany(\App\Models\Reaction::class)->where('dislike', '!=', 0);
   }

	/**
    * comments relation method
    * @param void
    * @return object data
    */
   	public function comments(){
      	return $this->hasMany(\App\Models\Comment::class);
   	}


   	public function group_id(){
		return $this->hasOne(\App\Models\AdminGroup::class, 'id', 'group_id');
	}


	public function icos(){
		return $this->hasMany(\App\Models\ICO::class);
	}


	public function votes(){
		$votes =  $this->likes()->count('like') + $this->dislikes()->count('dislike') + $this->comments()->count('id');
		return $votes;
	}


	/**number of prizes = number of conditions true
		$votes/$vote_plan->num_votes_cond ==> number of prizes
		$kuro_balance/$vote_plan->kuro_balance_cond ==> number of prizes
		$number_of_paid_prizes (number_of_conditions_true (balance&votes))
		 */
	public function vote_revenue(VotePlan $vote_plan){
		//check if conditions are true

		
		$unpaid_votes = ($this->votes() - $this->num_paid_votes);
		$unpaid_balance = ($this->kuro_balance - $this->paid_vote_plan_balance);

		/*check if num_cond not 0 nor 1*/
		
		if (($unpaid_votes >= $vote_plan->num_votes_cond) &&
		($unpaid_balance >= $vote_plan->kuro_balance_cond)){
			
		   	//check paid_prizes (VERY IMPORTANT: integers not double, closest to the smallest number 1.9=>1)
			if ($vote_plan->num_votes_cond == 0)
			   $num_prizes_based_on_votes = 1000000;
		   	elseif ($unpaid_votes == $vote_plan->num_votes_cond)
			   $num_prizes_based_on_votes = 1;
			   elseif ($vote_plan->num_votes_cond == 1)
				   $num_prizes_based_on_votes = $unpaid_votes - $vote_plan->num_votes_cond;
				   else
					   $num_prizes_based_on_votes = intdiv($unpaid_votes , $vote_plan->num_votes_cond);

			if ($vote_plan->kuro_balance_cond == 0)
				$num_prizes_based_on_kuro_balance = 1000000;
			elseif ($unpaid_balance == $vote_plan->kuro_balance_cond)
				$num_prizes_based_on_kuro_balance = 1;
				elseif ($vote_plan->kuro_balance_cond == 1)
					$num_prizes_based_on_kuro_balance = $unpaid_balance - $vote_plan->kuro_balance_cond;
					else
						$num_prizes_based_on_kuro_balance = intdiv($unpaid_balance , $vote_plan->kuro_balance_cond);

			// final revenue = num_prizes * revenue
			$num_prizes_based_on_votes = intdiv($unpaid_votes , $vote_plan->num_votes_cond);
			$num_prizes_based_on_kuro_balance = intdiv($unpaid_balance , $vote_plan->kuro_balance_cond);

			//He has a num_prizes
			if ($vote_plan->num_votes_cond == 0 && $vote_plan->kuro_balance_cond == 0)
				$num_of_prizes = 0;
			else
				$num_of_prizes = min($num_prizes_based_on_votes, $num_prizes_based_on_kuro_balance);
			return ($num_of_prizes * $vote_plan->revenue);  
		}
		return 0;
	}
	
	public function bfot_revenue(BFOTPlan $bfot_plan){
		$refs =  $this->referrals()->count();
		$unpaid_refs = ($refs - $this->num_paid_refs);
		$unpaid_balance = ($this->kuro_balance - $this->paid_bfot_plan_balance);
		/*check if num_cond not 0 nor 1*/
		if (($unpaid_refs >= $bfot_plan->num_of_refs_cond) &&
		($unpaid_balance >= $bfot_plan->kuro_balance_cond)){
		   	//check paid_prizes (VERY IMPORTANT: integers not double, closest to the smallest number 1.9=>1)
		   	// final revenue = num_prizes * revenue
			if ($bfot_plan->num_of_refs_cond == 0)
				$num_prizes_based_on_refs = 1000000;
			elseif ($unpaid_refs == $bfot_plan->num_of_refs_cond)
				$num_prizes_based_on_refs = 1;
				elseif ($bfot_plan->num_of_refs_cond == 1)
					$num_prizes_based_on_refs = $unpaid_refs - $bfot_plan->num_of_refs_cond;
					else
						$num_prizes_based_on_refs = intdiv($unpaid_refs , $bfot_plan->num_of_refs_cond);

			if ($bfot_plan->kuro_balance_cond == 0)
			   $num_prizes_based_on_kuro_balance = 1000000;
			elseif ($unpaid_balance == $bfot_plan->kuro_balance_cond)
				$num_prizes_based_on_kuro_balance = 1;
				elseif ($bfot_plan->kuro_balance_cond == 1)
					$num_prizes_based_on_kuro_balance = $unpaid_balance - $bfot_plan->kuro_balance_cond;
					else
						$num_prizes_based_on_kuro_balance = intdiv($unpaid_balance , $bfot_plan->kuro_balance_cond);

			if ($bfot_plan->num_of_refs_cond == 0 && $bfot_plan->kuro_balance_cond == 0)
				$num_of_prizes = 0;
			else
				$num_of_prizes = min($num_prizes_based_on_refs, $num_prizes_based_on_kuro_balance);
			return ($num_of_prizes * $bfot_plan->revenue);  
		}
		return 0;
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
