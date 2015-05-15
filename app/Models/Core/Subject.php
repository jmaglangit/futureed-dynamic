<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model {

	use SoftDeletes;

    protected $table = 'subjects';

    protected $dates = ['deleted_at'];

	protected $fillable = ['code', 'name', 'description', 'status'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];
    
	/**
	* holds the validaton rules
	*
	* @return mixed
	*/
	public static $rules = array(
		'code' => 'required|integer',
		'name' => 'required',
		'status' => 'required|in:Enabled,Disabled'
	);
    
    //-------------scopes
	public function scopeName($query, $name) {
		
		return $query->where('name', 'like', '%'.$name.'%');
				
	}

}
