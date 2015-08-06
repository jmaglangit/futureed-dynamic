<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Badge extends Model {

	use SoftDeletes;

	protected $table = 'badges';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	//-------------scopes
	public function scopeName($query, $name) {

		return $query->where('name', 'like', '%'.$name.'%');

	}

	public function scopeSubjectId($query, $subject_id) {

		return $query->where('subject_id','=',$subject_id);
	}

	public function scopeAgeGroupId($query, $age_group_id) {

		return $query->where('age_group_id','=',$age_group_id);
	}

	public function scopeGender($query, $gender) {

		return $query->where('gender','=',$gender);
	}



}
