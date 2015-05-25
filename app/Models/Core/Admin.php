<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model {


    use SoftDeletes;

    protected $table = 'admins';

    protected $dates = ['deleted_at'];

    protected $hidden = ['user_id','created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['user_id', 'first_name', 'last_name', 'admin_role'];

    /**
     * Inverse relation
     */
    public function user(){

        return $this->belongsTo('FutureEd\Models\Core\User');
    }

	//-------------scopes
	public function scopeUsername($query, $username) {
		
		return $query->whereHas('user', function($query) use ($username) {	
			$query->where('username', 'like', '%'.$username.'%');
		});
				
	}
	
	public function scopeEmail($query, $email) {
	
		return $query->whereHas('user', function($query) use ($email) {	
			$query->where('email', 'like', '%'.$email.'%');
		});
		
	}
	
	public function scopeRole($query, $role) {
		
		return $query->whereAdminRole($role);
				
	}


}
