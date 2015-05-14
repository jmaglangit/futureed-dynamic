<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {

	//
    use SoftDeletes;

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
        'registration_verification_token',
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


    protected $fillable = ['username', 'email', 'name', 'password', 'user_type', 'confirmation_code',
        'confirmation_code_expiry', 'created_by', 'updated_by'];

}
