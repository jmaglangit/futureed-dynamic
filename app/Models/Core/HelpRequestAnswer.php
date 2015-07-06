<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpRequestAnswer extends Model {

	use SoftDeletes;

	protected $table = 'help_request_answers';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'student_id',
		'content',
		'help_request_id',
		'module_id',
		'subject_id',
		'subject_area_id',
		'rating',
		'seq_no',
		'request_answer_status',
		'status',
		'points'
	];

    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 1,
        'module_id'=> 0,
        'subject_id'=> 0,
        'subject_area_id' => 0,
        'rating' => 0,
        'seq_no'=> 0,
        'request_answer_status' => 'Pending',
        'status' =>'Enabled',
        'points' => 0];

	protected $hidden = ['updated_by','created_at','deleted_at'];

	//Relationships
	public function helpRequest(){

		return $this->belongsTo('FutureEd\Models\Core\HelpRequest');
	}

	public function module(){

		return $this->belongsTo('FutureEd\Models\Core\Module');
	}

	public function subject(){

		return $this->belongsTo('FutureEd\Models\Core\Subject');
	}

	public function subjectArea(){

		return $this->belongsTo('FutureEd\Models\Core\SubjectArea');
	}

	public function user(){

		return $this->belongsTo('FutureEd\Models\Core\User','created_by');
	}


	//Scopes
	public function scopeRequestTitle($query, $help_request_title){

		return $query->whereHas('helpRequest', function($query) use ($help_request_title){
			$query->where('title', 'like','%'. $help_request_title . '%');
		});
	}

	public function scopeModuleName($query,$module_name){

		return $query->whereHas('module', function($query) use ($module_name){
			$query->where('name','like','%'.$module_name.'%');
		});
	}

	public function scopeSubjectName($query,$subject_name){

		return $query->whereHas('subject', function($query) use ($subject_name){
			$query->where('name','like','%'.$subject_name.'%');
		});
	}

	public function scopeSubjectAreaName($query,$subject_area_name){

		return $query->whereHas('subjectArea', function($query) use ($subject_area_name){
			$query->where('name','like','%'.$subject_area_name.'%');
		});
	}

	public function scopeAnswerStatus($query,$answer_status){

		$answer_status = (array) $answer_status;

		return $query->whereIn('request_answer_status', $answer_status);

	}

	public function scopeStatusEnabled($query){

		return $query->where('status', config('futureed.enabled'));
	}

    public function scopeHelpRequestId($query,$help_request_id){

        return $query->where('help_request_id', $help_request_id);
    }

	public function scopeCreatedBy($query, $created_by){

		return $query->whereHas('user',function($query) use ($created_by){

			$query->where('name','like','%'.$created_by.'%');
		});
	}

	public function scopeStatus($query,$status){

		return $query->where('status',$status);
	}

    public function scopeStudentId($query,$student_id){
        return $query->whereStudentId($student_id);
    }





}
