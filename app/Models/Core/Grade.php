<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;;

class Grade extends Model {

	//

    protected $table = 'grades';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

}
