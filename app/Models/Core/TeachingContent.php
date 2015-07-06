<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;

class TeachingContent extends Model {

	protected $table = 'teaching_contents';

	protected $date = ['created_at','updated_at','deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at'
	];

	protected $fillable = [
		'module_id',
		'subject_id',
		'subject_area_id',
		'code',
		'teaching_module',
		'description',
		'learning_style_id',
		'content_url',
		'media_type_id'
	];


	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];



}
