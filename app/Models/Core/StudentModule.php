<?php namespace FutureEd\Models\Core;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentModule extends Model {

    use SoftDeletes;

    protected $table = 'student_modules';

    protected $dates = ['deleted_at','date_start','date_end','created_at','updated_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['class_id', 'student_id', 'module_id', 'module_status', 'last_viewed_content_id', 'progress', 'date_start',
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

	//Relationship

	public function question(){

		return $this->belongsTo('FutureEd\Models\Core\Question','last_answered_question_id');
	}
}
