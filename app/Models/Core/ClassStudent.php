<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use FutureEd\Models\Core\User;
use FutureEd\Models\Core\Student;

class ClassStudent extends Model {

	//
	use SoftDeletes;

	protected $table = 'class_students';

	protected $dates = ['deleted_at'];

	protected $fillable = ['student_id', 'class_id', 'status', 'verification_code','date_started','date_removed'];

	protected $hidden = ['verification_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];


	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'subscription_status' => 'Active'

	];

	//Relationships

	public function user()
	{

		return $this->belongsToMany('FutureEd\Models\Core\User', 'students', 'id', 'user_id');
	}

	public function student()
	{

		return $this->belongsTo('FutureEd\Models\Core\Student')->with('user');
	}

	public function classroom()
	{
		return $this->belongsTo('FutureEd\Models\Core\Classroom', 'class_id', 'id')->with('subject','order');
	}

	//Student Class Modules
	public function studentClassroom(){

		return $this->belongsTo('FutureEd\Models\Core\Classroom','class_id')->with('studentSubject');

	}


	//Scopes

	//TODO: To be remove, check if used.
	public function scopeClassroom($query, $classroom)
	{

		return $query->where('class_id', $classroom);
	}


	public function scopeClassroomId($query, $class_id)
	{
		return $query->where('class_students.class_id', $class_id);
	}


	public function scopeName($query, $name)
	{

		return $query->whereHas('student', function ($query) use ($name) {
			$query->where(function($query) use ($name) {
				$query->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name', 'like', '%' . $name . '%');
			});
		});

	}

	public function scopeEmail($query, $email)
	{

		return $query->whereHas('student', function ($query) use ($email) {

			return $query->whereHas('user', function ($query) use ($email) {

				$query->where('email', 'like', '%' . $email . '%');

			});

		});

	}

	public function scopeStudentId($query,$student_id){

		return $query->where('class_students.student_id',$student_id);
	}

	public function scopeCurrentDate($query,$current_date){

		return $query->whereHas('classroom', function ($query) use ($current_date) {

			$query->whereHas('order', function ($query) use ($current_date) {

				$query->where('date_start', '<=', $current_date)

					->where('date_end', '>=', $current_date);
			});
		});
	}

	public function scopeActive($query){

		return $query->where('subscription_status',config('futureed.active'));
	}

	public function scopeId($query, $id){

		return $query->where('id',$id);
	}

	public function scopeModuleName($query, $module_name){

		return $query->whereHas('studentClassroom', function($query) use ($module_name){
			$query->whereHas('studentSubject', function($query) use ($module_name){
				$query->whereHas('studentModules', function($query) use ($module_name){

					$query->where('name','like', '%' . $module_name . '%');
				});
			});
		});
	}


}
