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

	protected $fillable = [
		'equation_type',
		'question_template_format',
		'question_equation',
		'status',
	];

	//scope
//'equation_type',
//		'question_template_format',
//		'question_equation',
//		'status',

	public function scopeEquationType($query, $equation_type){
		return $query->where('equation_type','=',$equation_type);
	}

	public function scopeQuestionTemplateFormat($query,$question_template_format){
		return $query->where('question_template_format','=',$question_template_format);
	}

	public function scopeQuestionEquation($query,$question_equation){
		return $query->where('question_equation','=',$question_equation);
	}

	public function scopeStatus($query,$status){
		return $query->where('status','=',$status);
	}

}