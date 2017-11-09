<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class SecurityLog extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $tables = 'security_logs';

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
		'client_ip',
		'client_port',
		'proxy_ip',
		'client_user_agent',
		'url',
		'result_response',
		'data_size_transferred',
		'log_type',
		'log_id',
		'status',
		'updated_by',
		'created_by'
	];


	// Scopes

	public function scopeUserId($query,$user_id){

		return $query->where('user_id',$user_id);
	}

	public function scopeUsername($query,$username){

		return $query->where('username','like','%'.$username.'%');
	}

	public function scopeClientIp($query, $client_ip){

		return $query->where('client_ip','like','%'.$client_ip.'%');
	}

	public function scopeClientPort($query, $client_port){

		return $query->where('client_port','like','%'.$client_port.'%');
	}

	public function scopeProxyIp($query, $proxy_ip){

		return $query->where('proxy_ip','like','%'.$proxy_ip.'%');
	}

	public function scopeClientUserAgent($query, $client_user_agent){

		return $query->where('client_user_agent','like', '%'.$client_user_agent.'%');
	}

	public function scopeUrl($query, $url){

		return $query->where('url','like','%'.$url.'%');
	}

	public function scopeResultResponse($query,$result_response){

		return $query->where('result_response',$result_response);
	}

	public function scopeDataSizeTransferred($query, $data_size_transferred){

		return $query->where('data_size_transferred',$data_size_transferred);
	}

	public function scopeStatus($query, $status){

		return $query->where('status',$status);
	}

	public function scopeDateStart($query,$date_start){

		return $query->where('created_at','>=',$date_start);
	}

	public function scopeDateEnd($query,$date_end){

		return $query->where('created_at','<=',$date_end);
	}

}
