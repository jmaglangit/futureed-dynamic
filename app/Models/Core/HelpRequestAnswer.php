<?php namespace FutureEd;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpRequestAnswer extends Model {

	use SoftDeletes;

	protected $table = 'help_request_answers';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'user_id',
		'content',
		'help_request_id',
		'module_id',
		'subject_id',
		'area_id',
		'rating',
		'seq_no',
		'is_verified',
		'status',
		'points'
	];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

}
