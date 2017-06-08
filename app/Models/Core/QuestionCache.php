<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/16/17
 * Time: 5:01 PM
 */

namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use FutureEd\Models\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCache extends Model{

//	use SoftDeletes;

	use TranslationTrait;

	use TransactionTrait;

	protected $table = 'question_cache';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = [
		'module_question_template_id',
		'question_template_id',
		'question_text',
		'question_values',
		'answer',
		'status'
	];

	protected $attibutes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//relationship
	public function questionTemplate(){

		return $this->hasOne('FutureEd\Models\Core\QuestionTemplate','id','question_template_id');
	}

	public function moduleQuestionTemplate(){

		return $this->hasMany('FutureEd\Models\Core\ModuleQuestionTemplate','id','module_question_template_id');
	}

	//scope
	public function scopeModuleQuestionTemplateId($query,$template_id){
		return $query->where('module_question_template_id',$template_id);
	}

	public function scopeQuestionTemplateId($query,$template_id){
		return $query->where('question_template_id',$template_id);
	}

	public function scopeQuestionText($query,$text){
		return $query->where('question_text',$text);
	}

	public function scopeStatus($query,$status){
		return $query->where('status',$status);
	}

	//get by module_id
	public function scopeModuleId($query,$module_id){
		return $query->whereHas('moduleQuestionTemplate',function ($query) use ($module_id){
			$query->where('module_id',$module_id);
		});

	}

}