<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/14/17
 * Time: 11:50 AM
 */

namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionTemplate extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'question_template';

	protected $date = [
		'created_at','updated_at','deleted_at'
	];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = [
		'question_type',
		'question_template_format',
		'question_equation',
		'operation',
		'question_form',
		'status'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//accessor
	public function getOperationAttribute(){
		return QuestionTemplateOperation::where('id',$this->attributes['operation'])->pluck('operation_data');
	}

	//relationship
	public function questionTemplateExplanation(){
		return $this->hasOne('FutureEd\Models\Core\QuestionTemplateExplanation');
	}

	//scope
	public function scopeQuestionType($query,$question_type){
		return $query->where('question_type',$question_type);
	}

	public function scopeQuestionTemplateFormat($query,$question_template_format){
		return $query->where('question_template_format',$question_template_format);
	}

	public function scopeQuestionEquation($query,$question_equation){
		return $query->where('question_equation',$question_equation);
	}

	public function scopeQuestionForm($query,$question_form){
		return $query->where('question_form','=',$question_form);
	}

	public function scopeStatus($query,$status){
		return $query->where('status','=',$status);
	}

	public function scopeOperation($query,$operation){
		return $query->where('operation','=',$operation);
	}
}