<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Filesystem;

class Question extends Model {

	use SoftDeletes;

	protected $table = 'questions';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'answer',
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'];

	protected $fillable =['module_id','code','question_type','questions_text','questions_image','answer'
		,'question_order_text','seq_no','difficulty','points_earned'
		,'original_image_name','status','created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'questions_image' =>0,
		'original_image_name' =>0,
		'seq_no' => 0
	];

	//Accessor
	public function getQuestionsImageAttribute($value){

		$filesystem = new Filesystem();

		//get path
		$image_path = config('futureed.question_image_path_final') .'/'. $this->attributes['id'] . '/'. $value;

		//check path
		if($filesystem->exists($image_path)){
			return asset(config('futureed.question_image_path_final_public') .'/'. $this->attributes['id'] . '/'. $value);

		} else {

			return 'None';
		}
	}

	//-------------relationships
	public function module() {
		return $this->belongsTo('FutureEd\Models\Core\Module')->with('subject','subjectArea');
	}

	//
	public function questionAnswers(){
		return $this->hasMany('FutureEd\Models\Core\QuestionAnswer');
	}

	//-------------scopes
	public function scopeQuestionType($query, $question_type)
	{

		return $query->where('question_type', '=', $question_type);

	}

	public function scopeQuestionText($query, $questions_text)
	{

		return $query->where('questions_text', 'like', '%'.$questions_text.'%');

	}

	public function scopeModuleId($query, $module_id)
	{

		return $query->where('module_id', '=', $module_id);

	}

	public function scopeId($query, $id){

		return $query->where('id',$id);
	}

	public function scopeSeqNo($query, $seq_no){

		return $query->where('seq_no',$seq_no);
	}

	public function scopeOrderBySeqNo($query){

		return $query->OrderBy('seq_no');
	}

	public function scopeOrderBySeqNoDesc($query){

		return $query->OrderBy('seq_no','desc');
	}

	public function scopeDifficulty($query,$difficulty){
		return $query->whereDifficulty($difficulty);
	}


}
