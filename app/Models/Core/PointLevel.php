<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointLevel extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'point_levels';

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//scope
	public function scopePointRequired($query, $points_required){

		return $query->where('points_required','<=',$points_required);

	}

	public function scopeOrderByPointRequiredDesc($query){

		return $query->orderBy('points_required','desc');

	}




}
