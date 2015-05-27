<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model {

	//
    use SoftDeletes;

    protected $table = 'clients';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];
	
	//-------------relationships
	public function user() {
		return $this->belongsTo('FutureEd\Models\Core\User');
	}

    //-------------relationships classroom
    public function classroom() {
        return $this->hasMany('FutureEd\Models\Core\Classroom');
    }

    public function school(){

        return $this->belongsTo('FutureEd\Models\Core\School','school_code','code');
    }
	
	//-------------scopes
	public function scopeName($query, $name) {
		
		return $query->where(function($query) use ($name) {
			$query->where('first_name', 'like', '%'.$name.'%')->orWhere('last_name', 'like', '%'.$name.'%');
		});
		
	}
	
	public function scopeEmail($query, $email) {
	
		return $query->whereHas('user', function($query) use ($email) {	
			$query->whereEmail($email);
		});
		
	}
	
	public function scopeRole($query, $role) {
	
		return $query->whereClientRole($role);
		
	}
	
	public function scopeTeacher($query) {
		return $query->whereClientRole(config('futureed.teacher'));
	}
	
	public function scopeStatus($query, $status) {
	
		return $query->whereHas('user', function($query) use ($status) {	
			$query->whereStatus($status);
		});
		
	}
	
	public function scopeSchool_Name($query, $school_name) {

        return $query->whereHas('school', function($query) use ($school_name){
           $query->where('name', 'like' , "%$school_name%");
        });
		
	}


}
