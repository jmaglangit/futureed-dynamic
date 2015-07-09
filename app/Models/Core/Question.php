<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model {

	use SoftDeletes;

	protected $table = 'questions';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'];

	protected $fillable =['module_id','code','question_type','questions_text','questions_image','answer','seq_no','difficulty','points_earned'
			     ,'status','created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'questions_image' =>0,
	];

	//-------------relationships
	public function module() {
		return $this->belongsTo('FutureEd\Models\Core\Module')->with('subject','subjectArea');
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


}
