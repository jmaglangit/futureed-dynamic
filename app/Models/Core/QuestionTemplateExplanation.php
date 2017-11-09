<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionTemplateExplanation extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'question_template_explanation';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = [
		'question_template_id',
		'explanation',
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

}
