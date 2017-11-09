<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLog extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $tables = 'user_logs';

	protected $dates = [
		'deleted_at',
		'created_at',
		'updated_at'
	];

	protected $hidden = [
		'created_by',
		'updated_by',
		'deleted_at',
		'created_at',
		'updated_at'
	];

	protected $fillable = [
		'user_id',
		'username',
		'email',
		'name',
		'user_type',
		'page_accessed',
		'api_accessed',
		'result_response',
		'status',
		'created_by',
		'updated_by'
	];

	protected $attributes = [
		'user_id' => 0,
		'username' => 'NA',
		'email' => 'NA',
		'name' => 'NA'
	];


	//Scopes

	public function scopeUserId($query,$user_id){

		return $query->where('user_id',$user_id);
	}

	public function scopeUsername($query,$username){

		return $query->where('username','like','%'.$username.'%');
	}

	public function scopeEmail($query,$email){

		return $query->where('email','like','%'.$email.'%');
	}

	public function scopeName($query,$name){

		return $query->where('name','like','%'.$name.'%');
	}

	public function scopeUserType($query,$user_type){

		return $query->where('user_type',$user_type);
	}

	public function scopePageAccessed($query,$accessed){

		return $query->where('page_accessed','like','%'.$accessed.'%');
	}

	public function scopeApiAccessed($query,$accessed){

		return $query->where('api_accessed','like','%'.$accessed.'%');
	}

	public function scopeResultResponse($query,$result_response){

		return $query->where('result_response',$result_response);
	}

	public function scopeStatus($query,$status){

		return $query->where('status',$status);
	}

	public function scopeDateStart($query,$date_start){

		return $query->where('created_at','>=',$date_start);
	}

	public function scopeDateEnd($query,$date_end){

		return $query->where('created_at','<=',$date_end);
	}


}
