<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

trait AdminTransactionTrait {

	//TODO: Make use of generic trait.
	protected static function boot() {

		parent::boot();

		static::creating(function($model){

			$model->created_by = (session()->has('current_user'))? session('current_user') : 1;

		});

		static::updating(function($model){

			$model->updated_by = (session()->has('current_user'))? session('current_user') : 1;

		});

		Admin::deleting(function($admin){

			$admin->user->delete();

		});
	}
}
class Admin extends Model {


    use SoftDeletes;

	use AdminTransactionTrait;

    protected $table = 'admins';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['user_id', 'first_name', 'last_name', 'admin_role'];

    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 1
    ];

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
