<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentPoint extends Model {

	use SoftDeletes;

	protected $table = 'student_points';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = ['student_id','points_earned','event_id','description','earned_at','created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,

	];

	//scope
	public function scopeStudentId($query,$student_id){

		$query->where('student_id','=' ,$student_id);

	}



}
