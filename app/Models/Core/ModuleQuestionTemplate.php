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

	protected $table = 'module_question_template';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = [
		'module_id',
		'question_template_id',
		'status'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//relationship
	public function questionCache(){
		return $this->hasOne('FutureEd\Models\Core\QuestionCache');
	}

	//scope
	public function scopeQuestionTemplateId($query,$template_id){
		return $query->where('question_template_id',$template_id);
	}

	public function scopeModuleId($query,$module_id){
		return $query->where('module_id',$module_id);
	}

	public function scopeStatus($query,$status){
		return $query->where('status',$status);
	}

}