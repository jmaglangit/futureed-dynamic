<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/15/17
 * Time: 3:24 PM
 */

namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataLibrary extends Model  {

	use SoftDeletes;

	use TranslationTrait;

	protected $table = 'data_library';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'object_type',
		'object_name',
		'status',
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


	//scope
	public function scopeObjectType($query,$object_type){
		return $query->where('object_type','=',$object_type);
	}

	public function scopeObjectName($query,$object_name){
		return $query->where('object_name','=',$object_name);
	}

	public function scopeStatus($query,$status){
		return $query->where('status','=',$status);
	}
}