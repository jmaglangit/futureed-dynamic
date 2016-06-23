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

	//Accessor
	public function getGameImageAttribute($value){
		//get path
		if(!empty($value)){
			return config('futureed.game_images_folder') . '/' . $this->attributes['id'] . '/' . $value;
		} else {
			return 'None';
		}
	}

	//relationships

	public function student_game(){

		return $this->hasMany('FutureEd\Models\Core\StudentGame','games_id');
	}

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

	public function scopeStudentGameUser($query, $user_id){

		return $query->whereHas('student_game', function($query) use ($user_id) {
			$query->where('user_id',$user_id);
		});
	}




}