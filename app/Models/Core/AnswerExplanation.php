<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use FutureEd\Models\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Filesystem;

class AnswerExplanation extends Model {

	use SoftDeletes;

	use TransactionTrait;

	use TranslationTrait

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
		'updated_by' => 1,
		'image' => 0
	];

	//accessor

	//Translation
	public function getAnswerAttribute($value){

		return $this->getAnswerExplanationTranslation($this->attributes['id'],$value,'answer_explanation');
	}

	public function getImageAttribute($value){
		$filesystem = new Filesystem();

		//get path
		$image_path = config('futureed.answer_explanation_image_final') . '/' . $this->attributes['image'];

		//check path
		if ($filesystem->exists($image_path) && !empty($value)) {
			return asset(config('futureed.answer_explanation_image_public') . '/' . $this->attributes['image']);

		} else {

			return 'None';
		}
	}

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
