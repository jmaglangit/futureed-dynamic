<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleCountry extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'module_countries';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'module_id',
		'country_id',
		'grade_id',
		'seq_no'
	];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	//relationships

	public function grade(){
		return $this->belongsTo('FutureEd\Models\Core\Grade');
	}

	public function module(){
		return $this->belongsTo('FutureEd\Models\Core\Module')->with('grade','subject','subjectArea');
	}

	public function studentModule() {
		return $this->hasMany('FutureEd\Models\Core\StudentModule','module_id','module_id')
			->with('classroom_order')
			->notFailed()
			->validModuleCountryClass();
	}

	public function country(){
		return $this->belongsTo('Webpatser\Countries\Countries');
	}

	//scope
	public function scopeSubjectId($query,$subject_id){
		return $query->whereHas('module',function($query) use ($subject_id){
			$query->where('subject_id',$subject_id);
		});
	}

	public function scopeSubjectName($query,$subject_name){
		return $query->whereHas('module',function($query) use ($subject_name){
			$query->whereHas('subject',function($query) use ($subject_name){
				$query->where('name','like','%'.$subject_name.'%');
			});
		});
	}

	public function scopeSubjectAreaName($query,$subject_area_name){
		return $query->whereHas('module',function($query) use ($subject_area_name){
			$query->whereHas('subject_area',function($query) use ($subject_area_name){
				$query->where('name','like','%'.$subject_area_name.'%');
			});
		});
	}

	public function scopeModuleName($query,$module_name){
		return $query->whereHas('module',function($query) use ($module_name){
			$query->where('name','like','%'. $module_name .'%');
		});
	}

	public function scopeStudent($query,$student_id){
		return $query->whereHas('studentModule', function($query) use ($student_id){
			$query->where('student_id',$student_id);
		});
	}

}