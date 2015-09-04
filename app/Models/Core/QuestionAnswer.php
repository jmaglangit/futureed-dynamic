<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswer extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'question_answers';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'];

	protected $fillable =['module_id','label','question_id','code','answer_text','answer_image','original_image_name','correct_answer','point_equivalent','difficulty',
		'created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'answer_image' => 0,
		'original_image_name' => 0,

	];

	//-------------scopes
	public function scopeQuestionId($query, $question_id){
		return $query->whereQuestionId($question_id);
	}

	public function scopeIsCorrectAnswer($query){
		return $query->whereCorrectAnswer('Yes');
	}

}
