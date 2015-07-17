<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipRating extends Model {

	use SoftDeletes;

	protected $table = 'tip_ratings';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'updated_at',
		'deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,

	];

	protected $fillable =['tip_id','student_id','rating','comments','created_by','updated_by'];


	//scope
	public function scopeTipId($query,$tip_id){

		$query->where('tip_id', $tip_id);

	}



}
