<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model {

	use SoftDeletes;

	use TransactionTrait;

    protected $table = 'subjects';

    protected $dates = ['deleted_at'];

	protected $fillable = ['code', 'name', 'description', 'status'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 1,
        'description' => 'None'
    ];
    
	/**
	* holds the validaton rules
	*
	* @return mixed
	*/
	public static $rules = array(
		'code' => 'required|integer|unique:subjects',
		'name' => 'required',
		'status' => 'required|in:Enabled,Disabled'
	);
    
	//-------------relationships
	public function areas() {
	
		return $this->hasMany('FutureEd\Models\Core\SubjectArea');
		
	}

	// Student Modules
	public function studentModules(){

		return $this->hasMany('FutureEd\Models\Core\Module');
	}
    
    //-------------scopes
	public function scopeName($query, $name) {
		
		return $query->where('name', 'like', '%'.$name.'%');
				
	}

	public function scopeStatus($query, $status) {

		return $query->where('status',$status);

	}

}
