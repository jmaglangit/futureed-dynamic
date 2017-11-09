<?php namespace FutureEd\Models\Core;

use Carbon\Carbon;
use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;

class SnapExerciseDetail extends Model {

	use TransactionTrait;

	protected $table = 'snap_exercise_details';

	protected $dates = [
		'created_at',
		'updated_at',
		'date_start',
		'date_end',
	];

	protected $fillable = [
		'classroom_id',
		'module_id',
		'order_id',
		'question_id',
		'question_seq_no',
		'student_module_id',
		'student_id',
		'is_exercise_completed',
		'date_start',
		'date_end',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
		'created_by',
		'updated_by'
	];

	/**
	 * Scopes
	 */
	public function scopeAnswered($query)
	{
		return $query->whereIsExerciseCompleted(1);
	}

	/**
	 * Mutators
	 */
	public function setDateStartAttribute($date)
	{
		$this->attributes['date_start'] = new Carbon($date);
	}

	public function setDateEndAttribute($date)
	{
		$this->attributes['date_end'] = new Carbon($date);
	}

}
