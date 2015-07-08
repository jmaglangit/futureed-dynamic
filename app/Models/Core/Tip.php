<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tip extends Model {

	use SoftDeletes;

	protected $table = 'tips';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'updated_at',
		'deleted_at'];

	protected $fillable =['class_id','student_id','title','content','module_id','subject_id','area_id','link_type','link_id'
                            ,'seq_no','rating','tip_status','status','created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'module_id' => 0,
		'subject_id' => 0,
		'subject_area_id' => 0,
		'link_id' => 0,
		'seq_no' => 0,
	];

	//-------------relationships
	public function subject() {
		return $this->belongsTo('FutureEd\Models\Core\Subject');
	}

	public function module(){
		return $this->belongsTo('FutureEd\Models\Core\Module');
	}

	public function subjectArea(){

		return $this->belongsTo('FutureEd\Models\Core\SubjectArea');

	}

	public function student(){

		return $this->belongsTo('FutureEd\Models\Core\Student')->with('avatar');

	}

	//-------------scopes
	public function scopeTipStatus($query, $tip_status) {

		return $query->where(function($query) use ($tip_status) {
			$query->where('tip_status', '=', $tip_status);

		});

	}

	public function scopeLinkType($query, $link_type) {

		return $query->where(function($query) use ($link_type) {
			$query->where('link_type', '=', $link_type);
		});

	}

	public function scopeSubjectName($query, $name) {

		return $query->whereHas('subject', function($query) use ($name) {
			$query->where('name','like','%'.$name.'%');
		});

	}

	public function scopeModuleName($query, $name) {

		return $query->whereHas('module', function($query) use ($name) {
			$query->where('name','like','%'.$name.'%');
		});

	}

	public function scopeSubjectAreaName($query, $name) {

		return $query->whereHas('subjectArea', function($query) use ($name) {
			$query->where('name','like','%'.$name.'%');
		});

	}

	public function scopeId($query, $id){

		return $query->where('id','=',$id);
	}

	public function scopeClassId($query, $class_id){

		return $query->where('class_id','=',$class_id);
	}

	public function scopeTitle($query,$title){

		return $query->where('title','like','%'.$title.'%');
	}

	public function scopeName($query,$name){

		return $query->whereHas('student', function($query) use ($name) {
			$query->where('first_name','like','%'.$name.'%')->orWhere('last_name', 'like', '%'.$name.'%');
		});

	}

	public function scopeAccepted($query){

		$query->where('tip_status', config('futureed.tip_status_accepted'));

	}

	public function scopeGeneral($query){

		$query->where('link_type', config('futureed.link_type_general'));

	}




}
