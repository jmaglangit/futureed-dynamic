<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {

	//
    use SoftDeletes;

    protected $table = 'users';

    protected $dates = ['deleted_at'];

    protected $hidden = ['password', 'created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['username', 'email', 'name', 'password', 'user_type', 'confirmation_code',
        'confirmation_code_expiry','status', 'created_by', 'updated_by'];
    
}
