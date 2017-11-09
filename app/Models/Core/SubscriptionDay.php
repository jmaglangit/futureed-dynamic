<?php namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionDay extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'subscription_days';

	protected $dates = ['deleted_at'];

	protected $fillable = ['days','status'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//scopes

	public function scopeDays($query,$days){
		return $query->where('days',$days);
	}

	public function scopeStatus($query,$status){
		return $query->where('status',$status);
	}
}