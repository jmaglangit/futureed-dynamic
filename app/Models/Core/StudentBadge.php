<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentBadge extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'student_badges';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','updated_at','deleted_at'];
	protected $fillable = ['student_id','subject_id','age_group_id','created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//-------------relationships
	public function badges() {
		return $this->belongsTo('FutureEd\Models\Core\Badge','subject_id','subject_id');
	}

	//-------------scopes
	public function scopeStudentId($query, $student_id) {

		return $query->whereStudentId($student_id);

	}

	public function scopeSubjectId($query, $subject_id){

		return $query->whereSubjectId($subject_id);
	}

	public function scopeAgeGroupId($query, $age_group_id){

		return $query->whereAgeGroupId($age_group_id);
	}




}
