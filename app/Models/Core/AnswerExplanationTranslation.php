<?php namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswerExplanationTranslation extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'answer_explanation_translations';

	protected $date = [
		'created_at','updated_at','deleted_at'
	];

	protected $fillable = [
		'answer_explanation_id',
		'answer_explanation',
		'locale'
	];
}