<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model {

	use TransactionTrait;

	protected $table = 'jobs';

	protected $dates = [
		'reserved_at','available_at','created_at'
	];
}