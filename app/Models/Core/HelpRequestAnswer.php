<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpRequestAnswer extends Model {

	use SoftDeletes;

	protected $table = 'help_request_answers';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'user_id',
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

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

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

		return $query->where('request_answer_status', $answer_status);

	}

	public function scopeStatusEnabled($query){

		return $query->where('status', config('futureed.enabled'));
	}




}
