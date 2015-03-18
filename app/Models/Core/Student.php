<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	//
    protected $table = 'students';

    protected $hidden = ['created_by_id','updated_by_id','created_at','updated_at','deleted_at'];

}
