<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningStyle extends Model {

    use SoftDeletes;

    protected $table = 'learning_styles';

    protected $date = ['created_at','updated_at','deleted_at'];

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at','deleted_at'];

    protected $fillable = ['name', 'description'];

    protected $attributes = ['created_by' => 1, 'updated_by' => 1];


	//-------------scopes
	public function scopeName($query, $name){

		return $query->where('name','like','%'.$name.'%');
	}
	
	public function scopeLsBanding($query, $ls_banding){

		return $query->where('ls_banding', 'like', $ls_banding);
	}

}
