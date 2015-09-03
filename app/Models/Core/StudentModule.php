<?php namespace FutureEd\Models\Core;

use Carbon\Carbon;
use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentModule extends Model {

    use SoftDeletes;

	use TransactionTrait;

    protected $table = 'student_modules';

    protected $dates = ['deleted_at','date_start','date_end','created_at','updated_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['class_id', 'student_id', 'subject_id', 'module_id', 'module_status', 'last_viewed_content_id', 'progress', 'date_start',
        'date_end', 'total_time', 'question_counter', 'wrong_counter','correct_counter', 'running_points', 'points_earned','last_answered_question_id',
        'total_correct_answer','current_difficulty_level', 'created_by','updated_by'];

    protected $attributes = [
		'progress' => 0,
		'total_time' => 0,
		'question_counter'=> 0,
        'wrong_counter' => 0,
		'correct_counter'=> 0,
		'running_points'=> 0,
		'points_earned'=> 0,
        'last_answered_question_id'=> 0,
		'total_correct_answer' => 0,
		'current_difficulty_level'=> 1,
		'created_by' => 1,
		'updated_by' => 1
	];

	//Mutator

	public function getAttributeDateStart($value){

		return Carbon::parse($value);
	}

	public function setAttributeDateStart($value){

		return (!$value) ? Carbon::now() : $value;
	}

	public function setAttributeDateEnd($value){

		return (!$value) ? Carbon::now() : $value;
	}


	//-------------relationships
	public function module() {
		return $this->belongsTo('FutureEd\Models\Core\Module');
	}

	public function question(){

		return $this->belongsTo('FutureEd\Models\Core\Question','last_answered_question_id');
	}

	public function classroom(){

		return $this->belongsTo('FutureEd\Models\Core\Classroom','class_id')->with('subject');
	}

	public function subject(){

		return $this->belongsTo('FutureEd\Models\Core\Subject','subject_id');
	}


	//-------------scope
	public function scopeStudentId($query, $student_id){

		return $query->where('student_id', '=',$student_id);
	}

	public function scopeProgress($query, $progress){

		return $query->where('progress', '=',$progress);
	}

	public function scopeSubjectId($query, $subject_id){

		return $query->whereHas('module', function($query) use ($subject_id){

				$query->where('subject_id',$subject_id);
		});

	}

	public function scopeGradeId($query, $grade_id){

		return $query->whereHas('module', function($query) use ($grade_id){

			$query->where('grade_id',$grade_id);
		});

	}

	public function scopeModuleId($query, $module_id){

		return $query->where('module_id',$module_id);
	}

	public function scopeNotFailed($query){

		return $query->where('module_status','<>',config('futureed.module_status_failed'));

	}

	public function scopeClassId($query, $class_id){

		$class_id = (array) $class_id;

		return $query->whereIn('class_id',$class_id);
	}




}
