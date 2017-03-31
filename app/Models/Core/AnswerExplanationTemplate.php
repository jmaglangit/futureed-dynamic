<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/16/17
 * Time: 4:45 PM
 */

namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use FutureEd\Models\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswerExplanationTemplate extends Model{

	use SoftDeletes;

	use TransactionTrait;

	use TranslationTrait;

	protected $table = 'answer_explanations_template';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = [
		'question_template_id',
		'template',
		'status'
	];

	protected $attibutes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//scope
	public function scopeTemplate($query,$template){
		return $query->where('template','like','%'.$template.'%');
	}

	public function scopeQuestionTemplateId($query,$template_id){
		return $query->where('question_template_id',$template_id);
	}

	public function scopeStatus($query,$status){
		return $query->where('status',$status);
	}



}