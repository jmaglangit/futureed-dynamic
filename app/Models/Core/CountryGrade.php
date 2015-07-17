<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryGrade extends Model {

	use SoftDeletes;

	protected $table = 'country_grades';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'age_group_id',
		'country_id',
		'grade_id'
	];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];


	//Scopes
	public function scopeGradeId($query, $grade_id){

		return $query->where('grade_id',$grade_id);
	}



}
