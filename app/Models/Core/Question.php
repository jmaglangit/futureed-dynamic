<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Filesystem;

class Question extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'questions';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $fillable = [
		'module_id',
		'code',
		'question_type',
		'questions_text',
		'questions_image',
		'answer',
		'question_order_text',
		'seq_no',
		'difficulty',
		'points_earned',
		'translatable',
		'original_image_name',
		'question_graph_content',
		'translatable',
		'status',
		'created_by',
		'updated_by'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'questions_image' => 0,
		'original_image_name' => 0,
		'seq_no' => 0
	];

	//Added fields not from the table.
	protected $appends = [
		'answer_text_field'
	];

	//Accessor
	public function getQuestionsImageAttribute($value) {

		$filesystem = new Filesystem();

		//get path
		$image_path = config('futureed.question_image_path_final') . '/' . $this->attributes['id'] . '/' . $value;

		//check path
		if ($filesystem->exists($image_path) && !empty($value)) {
			return asset(config('futureed.question_image_path_final_public') . '/' . $this->attributes['id'] . '/' . $value);

		} else {

			return 'None';
		}
	}

	public function getAnswerTextFieldAttribute($value) {

		if ($this->attributes['question_type'] == config('futureed.question_type_fill_in_the_blank')) {

			return count(explode(",", $this->attributes['answer']));

		} else {

			return null;
		}
	}

	//TODO: Remove this function. Remove answers on the controller level.
	public function getAnswerAttribute($value) {

		if (session('current_user') || session('super_access')) {

			$user = User::find(session('current_user'));

			//Check if user is Admin or not.
			if ($user->user_type == config('futureed.admin')) {

				return $value;
			} elseif (session('super_access') == 1) {

				return $value;
			} else {

				return null;
			}

		} else {

			return null;
		}

	}

	//-------------relationships
	public function module() {
		return $this->belongsTo('FutureEd\Models\Core\Module')->with('subject', 'subjectArea');
	}

	//
	public function questionAnswers() {
		return $this->hasMany('FutureEd\Models\Core\QuestionAnswer');
	}

	//-------------scopes
	public function scopeQuestionType($query, $question_type ) {

		$question_types = (array) $question_type;

		return $query->whereIn('question_type',$question_types);

	}

	public function scopeQuestionText($query, $questions_text) {

		return $query->where('questions_text', 'like', '%' . $questions_text . '%');

	}

	public function scopeModuleId($query, $module_id) {

		return $query->where('module_id', '=', $module_id);

	}

	public function scopeId($query, $id) {

		return $query->where('id', $id);
	}

	public function scopeOrderBySeqNo($query) {

		return $query->orderBy('seq_no');
	}

	public function scopeOrderByDifficulty($query) {

		return $query->orderBy('difficulty');
	}

	public function scopeOrderBySeqNoDesc($query) {

		return $query->orderBy('seq_no', 'desc');
	}

	public function scopeOrderById($query) {

		return $query->orderBy('id');
	}

	public function scopeDifficulty($query, $difficulty) {

		return $query->whereDifficulty($difficulty);
	}

	public function scopeStatus($query, $status) {

		return $query->whereStatus($status);
	}


}
