<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassStudent extends Model {

	//
	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'class_students';

	protected $dates = ['deleted_at'];

	protected $fillable = ['student_id', 'class_id', 'status', 'verification_code','date_started','date_removed', 'subscription_status'];

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

		return $this->belongsTo('FutureEd\Models\Core\Student', 'id')->with('user');
	}

	public function classroom()
	{
		return $this->belongsTo('FutureEd\Models\Core\Classroom', 'class_id', 'id')->with('subject','order','invoice');
	}

	//Student Class Modules
	public function studentClassroom(){

		return $this->hasOne('FutureEd\Models\Core\Classroom','id','class_id')->with('studentSubject');

	}

	public function student_classroom_module(){

		return $this->hasOne('FutureEd\Models\Core\Classroom','id','class_id')->with('module');
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


	public function scopeModuleName($query, $module_name) {

		return $query->whereHas('studentClassroom', function ($query) use ($module_name) {
			$query->whereHas('studentSubject', function ($query) use ($module_name) {
				$query->whereHas('studentModules', function ($query) use ($module_name) {

					$query->where('name', 'like', '%' . $module_name . '%');
				});
			});
		});
	}

	public function scopeIsDateRemovedNull($query){

		return $query->where('date_removed',NULL);

	}

	public function scopePaidOrder($query){

		return $query->whereHas('classroom', function ($query) {

			$query->whereHas('order', function ($query)  {

				$query->where('payment_status', '=', config('futureed.paid'));


			});
		});

	}

	public function scopeSubjectEnabled($query){

		return $query->whereHas('classroom', function ($query) {

			$query->whereHas('subject', function ($query) {

				$query->where('status',config('futureed.enabled'));
			});
		});
	}

	public function scopeSubscriptionSubjectId($query, $subject_id){
		return $query->whereHas('classroom', function($query) use ($subject_id){
			$query->where('subject_id', $subject_id);
		});
	}

	public function scopeSubscriptionStudentId($query, $student_id){
		$query->where('student_id', $student_id);
	}

	public function scopeSubscriptionStatus($query){
		$query->where('subscription_status', config('futureed.active'));
	}

	public function scopeModule($query, $module_id){

		return $query->whereHas('student_classroom_module', function($query) use ($module_id){
			$query->whereHas('module', function($query) use ($module_id){
				$query->whereId($module_id);
			});
		});
	}

	//check for package country
	public function scopeSubscriptionCountry($query,$country_id){

		return $query->whereHas('classroom',function($query) use ($country_id){
			$query->whereHas('invoice',function($query) use ($country_id){
				$query->whereHas('subscriptionPackage',function($query) use ($country_id){
					$query->where('country_id','=',$country_id);
				});
			});
		});
	}
}
