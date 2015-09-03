<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {

	//
    use SoftDeletes;

	use TransactionTrait;

    protected $table = 'users';

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'login_attempt',
        'confirmation_code',
        'confirmation_code_expiry',
        'reset_code',
        'reset_code_expiry',
        'is_link_to_parent',
        'is_account_activated',
        'is_account_locked',
        'is_account_deleted',
        'password_reset_token',
        'email_code',
        'email_code_expiry',
        'remember_token',
        'change_email_token',
        'change_email_token',
        'activated_at',
        'password',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['username', 'email','new_email', 'name', 'password', 'user_type', 'confirmation_code',

        'confirmation_code_expiry','email_code','email_code_expiry','registration_token','status', 'is_account_activated','created_by', 'updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

    
	//-------------relationships
	public function client() {
		return $this->hasOne('FutureEd\Models\Core\Client');
	}
	
	public function admin() {
		return $this->hasOne('FutureEd\Models\Core\Admin');
	}

}
