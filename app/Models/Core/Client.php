<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model {

	//
    use SoftDeletes;

    protected $table = 'client';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by_id','updated_by_id','created_at','updated_at','deleted_at'];


}
