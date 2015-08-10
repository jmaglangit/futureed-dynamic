<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentModuleAnswer extends Model {

	use SoftDeletes;

    protected $table = 'student_module_answers';

    protected $dates = ['deleted_at','date_start','date_end','created_at','updated_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['student_module_id','module_id','seq_no','question_id','answer_id','answer_text','points_earned','date_start','date_end','total_time','answer_status'];

    protected $attributes = [
		'total_time' => 0,
		'points_earned' => 0,
		'created_by' => 1,
		'updated_by' => 1,
	];

	//Mutators
	public function setAnswerIdAttribute($value){

		if($value == ''){

			$this->attributes['answer_id'] = 0;
		} else {

			$this->attributes['answer_id'] = $value;
		}
	}

	public function estAnswerTextAttribute($value){

		if($value == ''){
			$this->attributes['answer_text'] = 'NA';
		} else {
			$this->attributes['answer_text'] = $value;
		}
	}

	//Relationships

	public function module(){

		return $this->belongsTo('FutureEd\Models\Core\Module');
	}

	public function question(){

		return $this->belongsTo('FutureEd\Models\Core\Question');
	}

	//Scopes

	public function scopeStudentModuleId($query, $student_module_id){

		return $query->where('student_module_id',$student_module_id);
	}

	public function scopeModuleId($query, $module_id){

		return $query->where('module_id',$module_id);
	}

	public function scopeOrderBySeqNo($query){

		return $query->orderBy('seq_no');
	}

}
