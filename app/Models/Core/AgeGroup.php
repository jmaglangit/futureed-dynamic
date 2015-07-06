<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgeGroup extends Model {

	use SoftDeletes;

	protected $table = 'age_groups';

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

	protected $hidden = [
		'updated_by',
		'created_by',
		'updated_at',
		'created_at',
		'deleted_at'
	];

}
