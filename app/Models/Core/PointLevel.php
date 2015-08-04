<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointLevel extends Model {

	use SoftDeletes;

	protected $table = 'point_levels';

	//scope
	public function scopePointRequired($query, $points_required){

		return $query->where('points_required','<=',$points_required);

	}

	public function scopeOrderByPointRequiredDesc($query){

		return $query->orderBy('points_required','desc');

	}




}
