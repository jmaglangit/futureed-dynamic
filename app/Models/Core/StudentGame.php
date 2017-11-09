<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentGame extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'student_games';

	protected $dates = ['created_at', 'updated_at', 'deleted_at', 'earned_at'];

	protected $hidden = ['created_by', 'updated_by', 'updated_at', 'created_at', 'deleted_at'];

	protected $fillable = [
		'user_id',
		'games_id',
		'earned_at'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//relationship

	public function user() {
		return $this->belongsTo('FutureEd\Models\Code\User');
	}

	public function game() {
		return $this->belongsTo('FutureEd\Models\Code\Game');
	}

	//scopes

	public function scopeUserId($query, $user_id) {
		return $query->where('user_id', $user_id);
	}

	public function scopeGameId($query, $game_id) {
		return $query->where('games_id', $game_id);
	}
}