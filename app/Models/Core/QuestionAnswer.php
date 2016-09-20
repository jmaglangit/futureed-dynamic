<?php namespace FutureEd\Models\Core;

use Dimsav\Translatable\Translatable;
use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Session;

class 	QuestionAnswer extends Model {

	use Translatable;

	use SoftDeletes;

	use TransactionTrait;

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

	//translatable
	public $translatedAttributes = ['answer_text'];

	public $translationModel = 'FutureEd\Models\Core\QuestionAnswerTranslation';



	//Accessor
	public function getAnswerImageAttribute($value){

		$filesystem = new Filesystem();

		//get path
		$image_path = config('futureed.answer_image_path_final') .'/'. $this->attributes['id'] . '/'. $value;

		//check path
		if($filesystem->exists($image_path)){
			return asset(config('futureed.answer_image_path_final_public') .'/'. $this->attributes['id'] . '/'. $value);

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
