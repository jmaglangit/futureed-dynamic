<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/4/17
 * Time: 8:55 PM
 */

namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionGradeCondition extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'question_grade_condition';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = [
		'grade_id',
		'max_number'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];
}