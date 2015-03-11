<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Users extends Model {

	//
    protected $table = 'users';

    protected $hidden = ['created_by_id','updated_by_id','created_at','updated_at','deleted_at'];
    

}
