<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 10:48 AM
 */

namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use FutureEd\Models\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCacheLog extends Model{

	use SoftDeletes;

	use TransactionTrait;

	use TranslationTrait;

	protected $table = 'question_cache_log';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = [
		'user_id',
		'description',
		'status'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];


	public function scopeUserId($query,$user_id){
		return $query->where('user_id',$user_id);
	}

	public function scopeDescription($query,$description){
		return $query->where('description','like','%' . $description . '%');
	}

	public function scopeStatus($query,$status){
		return $query->where('status',$status);
	}

}