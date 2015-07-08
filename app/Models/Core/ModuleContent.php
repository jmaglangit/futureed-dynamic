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
		'updated_by' => 1
	];

	//Scopes
	public function scopeId($query, $id){

		return $query->where('id',$id);
	}

	public function scopeContentId($query, $content_id){

		return $query->where('content_id', $content_id);
	}



}
