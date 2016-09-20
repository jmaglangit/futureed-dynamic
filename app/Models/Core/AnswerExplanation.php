<?php namespace FutureEd\Models\Core;

use Dimsav\Translatable\Translatable;
use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswerExplanation extends Model {

	use Translatable;

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'answer_explanations';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = [
		'module_id',
		'question_id',
		'answer_id',
		'learning_style_id',
		'seq_no',
		'answer_explanation'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//Translation
	public $translatedAttributes = ['answer_explanation'];

	public $translationModel = 'FutureEd\Models\Core\AnswerExplanationTranslation';

	//scopes

	public function scopeModuleId($query, $module_id){

		return $query->where('module_id',$module_id);
	}

	public function scopeQuestionId($query, $question_id){

		return $query->where('question_id', $question_id);
	}

	public function scopeSeqNo($query, $seq_no){

		return $query->where('seq_no',$seq_no);
	}

}
