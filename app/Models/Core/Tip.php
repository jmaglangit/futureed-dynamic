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
		'created_at',
		'updated_at',
		'deleted_at'];

	protected $fillable =['class_id','student_id','title','content','module_id','subject_id','area_id','link_type','link_id'
                            ,'seq_no','rating','is_verified','status','created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'module_id' => 0,
		'subject_id' => 0,
		'area_id' => 0,
		'link_id' => 0,
		'seq_no' => 0,
		'is_verified' => 0,
	];





}
