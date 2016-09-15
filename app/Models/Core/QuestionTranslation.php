<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionTranslation extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'question_translations';

	protected $date = [
		'created_at','updated_at','deleted_at'
	];

	protected $fillable = [
		'question_id',
		'questions_text',
		'answer',
		'locale',
	];
}