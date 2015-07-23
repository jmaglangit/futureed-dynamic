<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleContent extends Model {

	use SoftDeletes;

	protected $table = 'module_contents';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'module_id',
		'subject_id',
		'subject_area_id',
		'content_id',
		'seq_no',
		'status'
	];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'content_id' => 0
	];

	//-------------relationships
	public function teachingContent() {
		return $this->belongsTo('FutureEd\Models\Core\TeachingContent','content_id','id')->with('learningStyle','mediaType');
	}

	//Scopes
	public function scopeId($query, $id){

		return $query->where('id',$id);
	}

	public function scopeContentId($query, $content_id){

		return $query->where('content_id', $content_id);
	}

	public function scopeModuleId($query, $module_id){

		return $query->where('module_id', $module_id);
	}

	public function scopeOrderBySeqNo($query){

		return $query->OrderBy('seq_no');
	}

	public function scopeOrderBySeqNoDesc($query){

		 return $query->orderBy('seq_no','desc');
	}



}
