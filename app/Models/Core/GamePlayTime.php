<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 12/19/16
 * Time: 11:16 AM
 */

namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GamePlayTime extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'game_play_times';

	protected $fillable = [
		'game_id',
		'student_id',
		'countdown_time_played',
		'date_played'
	];

	protected $hidden = ['created_by', 'updated_by', 'updated_at','created_at', 'deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
	];

}