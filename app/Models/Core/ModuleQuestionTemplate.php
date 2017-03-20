<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 10:43 AM
 */

namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use FutureEd\Models\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleQuestionTemplate extends Model{

	use SoftDeletes;

	use TransactionTrait;

	use TranslationTrait;

	protected $table = 'module_question_table';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = [
		'question_template_id',
		'template',
		'status'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//scope
	public function scopeQuestionTemplateId($query,$template_id){
		return $query->where('question_template_id',$template_id);
	}

	public function scopeTemplate($query,$template){
		return $query->where('template',$template);
	}

	public function scopeStatus($query,$status){
		return $query->where('status',$status);
	}

}