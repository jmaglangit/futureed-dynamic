<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{

	use SoftDeletes;

	protected $table = 'modules';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'];

	protected $fillable = ['subject_id', 'subject_area_id', 'grade_id', 'code', 'name', 'description', 'common_core_area'
                              ,'common_core_url', 'points_to_unlock', 'points_to_finish', 'status', 'created_by', 'updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'grade_id' => 0,
	];

	//-------------relationships
	public function subject() {
		return $this->belongsTo('FutureEd\Models\Core\Subject');
	}

	public function subjectArea() {
		return $this->belongsTo('FutureEd\Models\Core\SubjectArea');
	}

	public function grade() {
		return $this->belongsTo('FutureEd\Models\Core\Grade');
	}




	//Scopes
	public function scopeName($query, $name)
	{

		return $query->where('name', 'like', '%' . $name . '%');

	}

	public function scopeSubjectName($query, $name) {

		return $query->whereHas('subject', function($query) use ($name) {
			$query->where('name','like','%'.$name.'%');
		});

	}

	public function scopeSubjectAreaName($query, $name) {

		return $query->whereHas('subjectArea', function($query) use ($name) {
			$query->where('name','like','%'.$name.'%');
		});

	}
}
