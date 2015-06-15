<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentStudent extends Model {

	//
	use SoftDeletes;

	protected $table = 'parent_students';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = ['parent_user_id','student_user_id','invitation_code','status','created_by','updated_by'];
    

}
