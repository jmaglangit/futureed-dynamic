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

	use SoftDeletes;

	use TranslationTrait;

	use TransactionTrait;

	protected $table = 'question_cache';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = [
		'module_question_template_id',
		'question_template_id',
		'question_text'
	];

	protected $attibutes = [
		'created_by' => 1,
		'updated_by' => 1
	];

}