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

	protected $fillable = ['student_id', 'class_id', 'status', 'verification_code'];

	protected $hidden = ['class_id', 'student_id', 'verification_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];


	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,

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
		return $this->belongsTo('FutureEd\Models\Core\Classroom', 'class_id', 'id')->with('order');
	}


	//Scopes

	public function scopeClassroom($query, $classroom)
	{

		return $query->where('class_id', $classroom);
	}


	public function scopeUsername($query, $username)
	{

		return $query->whereHas('user', function ($query) use ($username) {

			$query->where('username', 'like', '%' . $username . '%');
		});

	}

	public function scopeEmail($query, $email)
	{

		return $query->whereHas('user', function ($query) use ($email) {
			$query->where('email', 'like', '%' . $email . '%');
		});

	}

	public function scopeStudentId($query,$student_id){

		return $query->where('student_id',$student_id);
	}

	public function scopeCurrDate($query,$current_date){

		return $query->whereHas('classroom', function ($query) use ($current_date) {

			$query->whereHas('order', function ($query) use ($current_date) {

				$query->where('date_start', '<=', $current_date)

					->where('date_end', '>=', $current_date);
			});
		});
	}


}
