<?php namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswerTranslation extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'question_answer_translations';

	protected $date = [
		'created_at','updated_at','deleted_at'
	];

	protected $fillable = [
		'question_answer_id',
		'answer_text',
		'locale'
	];

}