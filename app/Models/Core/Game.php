<?php namespace FutureEd\Models\Core;


use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'games';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'code',
		'name',
		'game_url',
		'game_image',
		'points_price',
		'description'
	];

	protected $hidden = ['created_by', 'updated_by', 'updated_at','created_at', 'deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
	];

	//scopes

	public function scopeCode($query,$code){

		return $query->where('code',$code);
	}

	public function scopeName($query,$name){

		return $query->where('name',$name);
	}

	public function scopePointsPrice($query,$points_price){

		return $query->where('points_price',$points_price);
	}




}