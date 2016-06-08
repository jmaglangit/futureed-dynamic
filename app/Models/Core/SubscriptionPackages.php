<?php namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPackages extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'subscription_packages';

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'subject_id',
		'days_id',
		'subscription_id',
		'country_id',
		'price',
		'status'
	];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//relationships

	public function subject(){
		return $this->belongsTo('FutureEd\Models\Core\Subject');
	}

	public function subscription_day(){
		return $this->belongsTo('FutureEd\Models\Core\SubscriptionDay','days_id','id');
	}

	public function country(){
		return $this->belongsTo('Webpatser\Countries\Countries');
	}

	public function subscription(){
		return $this->belongsTo('FutureEd\Models\Core\Subscription');
	}

	//scopes

	public function scopeSubjectId($query, $subject_id){
		return $query->where('subject_id',$subject_id);
	}

	public function scopeDayId($query, $days_id){
		return $query->where('days_id',$days_id);
	}

	public function scopeSubscriptionId($query, $subscription_id){
		return $query->where('subscription_id',$subscription_id);
	}

	public function scopeCountryId($query, $country_id){
		return $query->where('country_id',$country_id);
	}

	public function scopeStatus($query, $status){
		return $query->where('status',$status);
	}
}