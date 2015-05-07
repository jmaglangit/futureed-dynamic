<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;

class PasswordImage extends Model {

	//
    protected $table = 'password_images';

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

}
