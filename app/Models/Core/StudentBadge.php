<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentBadge extends Model {

	use SoftDeletes;

	protected $table = 'student_badges';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','updated_at','deleted_at'];
	protected $fillable = ['student_id','badge_id','created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//-------------relationships
	public function badges() {
		return $this->belongsTo('FutureEd\Models\Core\Badge','badge_id','id');
	}

	//-------------scopes
	public function scopeStudentId($query, $student_id) {

		return $query->where('student_id', '=', $student_id);

	}




}
