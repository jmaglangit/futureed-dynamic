<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentBadge extends Model {

	use SoftDeletes;

	protected $table = 'student_badges';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	//-------------relationships
	public function badges() {
		return $this->belongsTo('FutureEd\Models\Core\Badge','badge_id','id');
	}

	//-------------scopes
	public function scopeStudentId($query, $student_id) {

		return $query->where('student_id', '=', $student_id);

	}




}
