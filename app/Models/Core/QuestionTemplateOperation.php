<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/4/17
 * Time: 8:54 PM
 */

namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionTemplateOperation extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'question_template_operation';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = [
		'operation_data',
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];
}