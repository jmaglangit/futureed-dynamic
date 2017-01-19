<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use FutureEd\Models\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Filesystem;

class QuestionAnswer extends Model {

	use SoftDeletes;

	use TransactionTrait;

	use TranslationTrait;

	protected $table = 'question_answers';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $fillable =[
		'module_id',
		'label',
		'question_id',
		'code',
		'answer_text',
		'answer_image',
		'original_image_name',
		'correct_answer',
		'point_equivalent',
		'translatable',
		'difficulty',
		'translatable',
		'created_by',
		'updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'answer_image' => 0,
		'original_image_name' => 0,

	];

	public $translatedAttributes = ['answer_text'];

	//Accessor

	//translatable
	public function getAnswerAttribute($value){

		return $this->getQuestionAnswerTranslation($this->attributes['id'],$value,'answer');
	}


	public function getAnswerImageAttribute($value){

		$filesystem = new Filesystem();

		//get path
		$image_path = config('futureed.answer_image_path_final') .'/'. $value;

		//check path
		if($filesystem->exists($image_path) && $value != ''){
			return asset(config('futureed.answer_image_path_final_public') .'/'. $value);

		} else {

			return 'None';
		}
	}

	//TODO: Remove this function. Remove answers on the controller level.
	public function getCorrectAnswerAttribute($value){


		if(session('current_user') || session('super_access')){

			$user = User::find(session('current_user'));

			//Check if user is Admin or not.
			if($user->user_type == config('futureed.admin')){

				return $value;
			} elseif(session('super_access') == 1){

				return $value;
			}else{

				return null;
			}

		} else {

			return null;
		}

	}


	//-------------scopes
	public function scopeQuestionId($query, $question_id){
		return $query->whereQuestionId($question_id);
	}

	public function scopeIsCorrectAnswer($query){
		return $query->whereCorrectAnswer('Yes');
	}

}
